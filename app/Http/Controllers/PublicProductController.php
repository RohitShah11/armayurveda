<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->orderBy('name')->get();

        $products = Product::with('category')
            ->where('is_active', true)
            ->whereHas('category', fn ($query) => $query->where('is_active', true))
            ->when($request->filled('category'), function ($query) use ($request) {
                $category = Category::where('slug', $request->category)->where('is_active', true)->first();
                if (! $category) {
                    return $query->whereRaw('1 = 0');
                }
                $categoryIds = $category->children()->where('is_active', true)->pluck('id')->push($category->id);

                return $query->whereIn('category_id', $categoryIds);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim();
                $query->where(fn ($inner) => $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%"));
            })
            ->latest()->paginate(12)->withQueryString();

        return view('front.products', compact('categories', 'products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active && $product->category?->is_active, 404);
        $relatedProducts = Product::where('is_active', true)->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)->latest()->take(4)->get();

        return view('front.product-details', compact('product', 'relatedProducts'));
    }
}
