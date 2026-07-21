<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->when($request->filled('search'), function ($q) use ($request) {
            $q->where(fn ($x) => $x->where('name', 'like', '%'.$request->search.'%')->orWhere('brand', 'like', '%'.$request->search.'%')->orWhere('hsn_code', 'like', '%'.$request->search.'%'));
        })->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', ['products' => $products, 'categories' => Category::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.products.create', ['product' => new Product, 'categories' => Category::where('is_active', true)->orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->storeImages($request, $data);
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product);
        if ($request->hasFile('image') && $product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($request->hasFile('gallery_images')) {
            Storage::disk('public')->delete($product->gallery_images ?? []);
        }
        $this->storeImages($request, $data);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete(array_filter(array_merge([$product->image], $product->gallery_images ?? [])));
        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id', 'seller' => 'nullable|string|max:255', 'brand' => 'nullable|string|max:255',
            'name' => 'required|string|max:255', 'slug' => ['required', 'alpha_dash', 'max:255', Rule::unique('products')->ignore($product)],
            'hsn_code' => 'nullable|string|max:50', 'repurchase_distribution' => 'nullable|numeric|min:0', 'mrp' => 'required|numeric|min:0',
            'retail_price' => 'required|numeric|min:0|lte:mrp', 'refund_days' => 'nullable|integer|min:0|max:365', 'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array|max:8', 'gallery_images.*' => 'image|max:2048', 'product_section' => 'nullable|string|max:100',
            'has_variants' => 'required|boolean', 'short_description' => 'nullable|string|max:2000', 'refund_description' => 'nullable|string|max:2000',
            'full_description' => 'nullable|string', 'is_active' => 'required|boolean',
        ]);
    }

    private function storeImages(Request $request, array &$data): void
    {
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        if ($request->hasFile('gallery_images')) {
            $data['gallery_images'] = collect($request->file('gallery_images'))->map(fn ($image) => $image->store('products/gallery', 'public'))->all();
        }
    }
}
