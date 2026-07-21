@extends('layouts.app')
@section('title', $category ? $category->name : 'Products')
@section('page-title', $category ? $category->name : 'All Products')
@push('styles')
<style>
.customer-panel{background:#fff;border-radius:14px;padding:20px;box-shadow:0 7px 22px rgba(0,0,0,.06)}
.catalog-card{background:#fff;border:1px solid #eee;border-radius:16px;overflow:hidden;height:100%;box-shadow:0 7px 22px rgba(0,0,0,.06);transition:.2s}.catalog-card:hover{transform:translateY(-4px)}
.catalog-image{height:220px;width:100%;object-fit:cover;background:#f3f4f6}.catalog-placeholder{height:220px;display:flex;align-items:center;justify-content:center;background:#f3f4f6;color:#9ca3af;font-size:42px}
.catalog-body{padding:18px}.catalog-price{color:#7b1e3a;font-weight:800;font-size:20px}.old-price{text-decoration:line-through;color:#999;font-size:14px}.category-pill{font-size:12px;background:#f6e9ee;color:#7b1e3a;border-radius:20px;padding:5px 10px}
</style>
@endpush
@section('content')
<div class="container-fluid py-4">
  <div class="customer-panel mb-4">
    <form method="GET" class="row g-2"><div class="col-md-8"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Search products by name, brand or description..."></div><div class="col-md-4"><button class="btn btn-main w-100"><i class="fa fa-search me-1"></i> Search</button></div></form>
  </div>
  <div class="row g-4">
    @forelse($products as $product)
    <div class="col-sm-6 col-xl-3"><div class="catalog-card">
      @if($product->image)<img class="catalog-image" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">@else<div class="catalog-placeholder"><i class="fa fa-box"></i></div>@endif
      <div class="catalog-body"><span class="category-pill">{{ $product->category->name }}</span><h5 class="fw-bold mt-3 mb-2">{{ $product->name }}</h5><p class="text-muted small">{{ Str::limit($product->short_description, 85) }}</p><div class="mb-3"><span class="catalog-price">₹{{ number_format($product->retail_price,2) }}</span> @if($product->mrp > $product->retail_price)<span class="old-price ms-2">₹{{ number_format($product->mrp,2) }}</span>@endif</div><a class="btn btn-main w-100" href="{{ route('catalog.show',$product) }}">View Details</a></div>
    </div></div>
    @empty<div class="col-12"><div class="customer-panel text-center py-5 text-muted"><i class="fa fa-box-open fa-3x mb-3"></i><h5>No products found</h5><p class="mb-0">Products added by the admin will appear here.</p></div></div>@endforelse
  </div>
  <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
