@extends('layouts.front')
@section('title', 'Our Products')
@section('content')
<section class="py-5 text-center text-white" style="background:linear-gradient(135deg,#064719,#0b6b2a)"><div class="container"><h1 class="fw-bold">Our Products</h1><p class="lead mb-0">Explore our admin-managed Ayurvedic wellness and personal care range.</p></div></section>

<section class="py-5 bg-light"><div class="container">
  <form method="GET" action="{{ route('products') }}" class="bg-white shadow-sm rounded-4 p-4 mb-4"><div class="row g-3"><div class="col-md-6"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search products by name, brand or description..."></div><div class="col-md-4"><select class="form-select" name="category"><option value="">All Categories</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(request('category')===$category->slug)>{{ $category->name }}</option>@endforeach</select></div><div class="col-md-2"><button class="btn btn-main w-100"><i class="fa fa-search me-1"></i> Search</button></div></div></form>

  <div class="d-flex flex-wrap justify-content-center gap-2 mb-4"><a class="category-filter {{ request('category') ? '' : 'active' }}" href="{{ route('products', request()->only('search')) }}">All</a>@foreach($categories as $category)<a class="category-filter {{ request('category')===$category->slug?'active':'' }}" href="{{ route('products', array_filter(['category'=>$category->slug,'search'=>request('search')])) }}">{{ $category->name }}</a>@endforeach</div>

  <div class="row g-4">
    @forelse($products as $product)
      <div class="col-sm-6 col-lg-4 col-xl-3"><div class="dynamic-product-card">
        <a href="{{ route('products.show',$product) }}">@if($product->image)<img class="dynamic-product-image" src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}">@else<div class="product-placeholder"><i class="fa fa-leaf"></i></div>@endif</a>
        <div class="p-4"><span class="product-category">{{ $product->category->name }}</span><h5 class="fw-bold mt-3"><a class="text-decoration-none text-dark" href="{{ route('products.show',$product) }}">{{ $product->name }}</a></h5><p class="text-muted small product-summary">{{ Str::limit($product->short_description,90) }}</p><div class="mb-3"><span class="price">₹{{ number_format($product->retail_price,2) }}</span>@if($product->mrp>$product->retail_price)<span class="text-muted text-decoration-line-through ms-2">₹{{ number_format($product->mrp,2) }}</span>@endif</div><a class="btn btn-main w-100" href="{{ route('products.show',$product) }}">View Details</a></div>
      </div></div>
    @empty<div class="col-12"><div class="bg-white rounded-4 p-5 text-center"><i class="fa fa-box-open fa-3x text-muted mb-3"></i><h4>No products found</h4><p class="text-muted mb-0">Try another search or category.</p></div></div>@endforelse
  </div>
  <div class="mt-5 d-flex justify-content-center">{{ $products->links() }}</div>
</div></section>
@push('styles')<style>
.category-filter{padding:9px 18px;border:1px solid #064719;border-radius:25px;color:#064719;text-decoration:none;font-weight:700}.category-filter:hover,.category-filter.active{background:#064719;color:#fff}.dynamic-product-card{height:100%;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 8px 25px rgba(0,0,0,.08);transition:.25s}.dynamic-product-card:hover{transform:translateY(-6px)}.dynamic-product-image,.product-placeholder{width:100%;height:230px;object-fit:cover;background:#edf5ef}.product-placeholder{display:flex;align-items:center;justify-content:center;font-size:45px;color:#799b80}.product-category{font-size:12px;background:#edf5ef;color:#064719;padding:6px 11px;border-radius:20px;font-weight:700}.product-summary{min-height:42px}.price{font-size:20px;font-weight:900;color:#064719}
</style>@endpush
@endsection
