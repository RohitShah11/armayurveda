<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainWalletTransaction;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = ProductOrder::with(['user', 'product'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('order_number', 'like', "%{$search}%")
                        ->orWhere('product_name', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%")->orWhere('member_id', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest('ordered_at')->paginate(20)->withQueryString();

        return view('admin.product-orders.index', compact('orders'));
    }

    public function update(Request $request, ProductOrder $productOrder)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(ProductOrder::STATUSES)],
            'admin_note' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($productOrder, $data) {
            $order = ProductOrder::lockForUpdate()->findOrFail($productOrder->id);

            if ($order->status === 'Cancelled' && $data['status'] !== 'Cancelled') {
                abort(422, 'A cancelled and refunded order cannot be reopened.');
            }

            if ($data['status'] === 'Cancelled' && $order->payment_status === 'Paid') {
                $user = User::lockForUpdate()->findOrFail($order->user_id);
                $opening = (float) $user->main_wallet;
                $closing = $opening + (float) $order->total_amount;
                $user->update(['main_wallet' => $closing]);
                MainWalletTransaction::create([
                    'user_id' => $user->id, 'transaction_type' => 'Credit', 'amount' => $order->total_amount,
                    'opening_balance' => $opening, 'closing_balance' => $closing,
                    'particular' => 'Repurchase order refund', 'remarks' => "Refund for {$order->order_number}",
                    'transaction_date' => now(), 'created_by' => Auth::guard('admin')->id(),
                ]);
                $order->payment_status = 'Refunded';
            }

            $order->status = $data['status'];
            $order->admin_note = $data['admin_note'] ?? null;
            $order->save();
        });

        return back()->with('success', 'Order status updated successfully.');
    }
}
