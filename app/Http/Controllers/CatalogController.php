<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainWalletTransaction;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CatalogController extends Controller
{
    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->with(['children' => fn ($query) => $query
                ->where('is_active', true)
                ->withCount(['products' => fn ($productQuery) => $productQuery->where('is_active', true)])
                ->orderBy('name')])
            ->orderBy('name')
            ->get();

        return view('pages.catalog.categories', compact('categories'));
    }

    public function products(Request $request, Category $category)
    {
        abort_unless($category->is_active, 404);

        $categoryIds = $category->children()->where('is_active', true)->pluck('id')->push($category->id);

        $products = Product::with('category')
            ->where('is_active', true)
            ->whereHas('category', fn ($query) => $query->where('is_active', true))
            ->whereIn('category_id', $categoryIds)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim();
                $query->where(fn ($inner) => $inner
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.catalog.index', compact('products', 'category'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active && $product->category?->is_active, 404);

        $relatedProducts = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->latest()->take(4)->get();

        return view('pages.catalog.show', compact('product', 'relatedProducts'));
    }

    public function purchase(Request $request, Product $product)
    {
        abort_unless($product->is_active && $product->category?->is_active, 404);
        $data = $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $order = DB::transaction(function () use ($request, $product, $data) {
            $user = User::lockForUpdate()->findOrFail($request->user()->id);
            $lockedProduct = Product::whereKey($product->id)->where('is_active', true)->lockForUpdate()->firstOrFail();
            $total = round((float) $lockedProduct->retail_price * $data['quantity'], 2);
            $opening = (float) $user->main_wallet;

            if ($opening < $total) {
                return null;
            }

            $closing = $opening - $total;
            $user->update(['main_wallet' => $closing]);
            $order = ProductOrder::create([
                'order_number' => 'RPO-'.now()->format('YmdHis').'-'.str_pad((string) $user->id, 4, '0', STR_PAD_LEFT).'-'.random_int(100, 999),
                'user_id' => $user->id, 'product_id' => $lockedProduct->id, 'product_name' => $lockedProduct->name,
                'unit_price' => $lockedProduct->retail_price, 'quantity' => $data['quantity'], 'total_amount' => $total,
                'status' => 'Pending', 'payment_status' => 'Paid', 'ordered_at' => now(),
            ]);
            MainWalletTransaction::create([
                'user_id' => $user->id, 'transaction_type' => 'Debit', 'amount' => $total,
                'opening_balance' => $opening, 'closing_balance' => $closing,
                'particular' => 'Product repurchase', 'remarks' => "Order {$order->order_number}: {$lockedProduct->name} x {$data['quantity']}",
                'transaction_date' => now(), 'created_by' => $user->id,
            ]);

            return $order;
        });

        if (! $order) {
            return back()->with('error', 'Insufficient main wallet balance for this purchase.');
        }

        return redirect()->route('catalog.orders')->with('success', "Purchase successful. Order {$order->order_number} is pending.");
    }

    public function orders(Request $request)
    {
        $orders = ProductOrder::with('product')->where('user_id', $request->user()->id)->latest('ordered_at')->paginate(15);

        return view('pages.catalog.orders', compact('orders'));
    }

    public function invoice(Request $request, ProductOrder $productOrder)
    {
        abort_unless($productOrder->user_id === $request->user()->id, 403);

        $productOrder->load(['product.category', 'user']);
        $profile = Schema::hasTable('member_profiles') ? $productOrder->user->profile()->first() : null;
        $invoiceNumber = 'ARM/INV/'.$productOrder->ordered_at->format('Y').'/'.str_pad((string) $productOrder->id, 6, '0', STR_PAD_LEFT);

        // Repurchase prices are customer-facing, GST-inclusive prices.
        $taxableAmount = round((float) $productOrder->total_amount / 1.05, 2);
        $cgst = round($taxableAmount * 0.025, 2);
        $sgst = round((float) $productOrder->total_amount - $taxableAmount - $cgst, 2);

        return view('pages.catalog.invoice', compact('productOrder', 'profile', 'invoiceNumber', 'taxableAmount', 'cgst', 'sgst'));
    }
}
