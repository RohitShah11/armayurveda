@extends('layouts.app')
@section('title', $product->name)
@section('page-title', 'Product Details')
@push('styles')
<style>.customer-panel{background:#fff;border-radius:14px;padding:22px;box-shadow:0 7px 22px rgba(0,0,0,.06)}.detail-image{width:100%;max-height:470px;object-fit:contain;background:#f8f9fa;border-radius:16px}.gallery-thumb{width:80px;height:80px;object-fit:cover;border:1px solid #ddd;border-radius:10px}.detail-price{font-size:30px;font-weight:900;color:var(--primary)}.detail-section{border-top:1px solid #eee;padding-top:20px;margin-top:20px}</style>
@endpush
@section('content')
<div class="container-fluid py-4">
  <a href="{{ route('catalog.category',$product->category) }}" class="text-decoration-none"><i class="fa fa-arrow-left me-1"></i> Back to {{ $product->category->name }}</a>
  <div class="customer-panel mt-3"><div class="row g-4">
    <div class="col-lg-5">@if($product->image)<img id="mainProductImage" class="detail-image" src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}">@else<div class="detail-image d-flex align-items-center justify-content-center text-muted" style="height:400px"><i class="fa fa-box fa-4x"></i></div>@endif
      @if($product->gallery_images)<div class="d-flex flex-wrap gap-2 mt-3">@foreach($product->gallery_images as $gallery)<img class="gallery-thumb" role="button" src="{{ Storage::disk('public')->url($gallery) }}" alt="" onclick="document.getElementById('mainProductImage').src=this.src">@endforeach</div>@endif
    </div>
    <div class="col-lg-7"><span class="badge bg-success">{{ $product->category->name }}</span>@if($product->product_section)<span class="badge bg-warning text-dark">{{ $product->product_section }}</span>@endif<h2 class="fw-bold mt-3">{{ $product->name }}</h2>@if($product->brand)<p class="text-muted mb-2">Brand: {{ $product->brand }}</p>@endif<div class="detail-price">₹{{ number_format($product->retail_price,2) }} @if($product->mrp>$product->retail_price)<small class="text-muted text-decoration-line-through fs-6">MRP ₹{{ number_format($product->mrp,2) }}</small>@endif</div><p class="mt-3">{{ $product->short_description }}</p>
      <form method="POST" action="{{ route('catalog.purchase', $product) }}" class="border rounded-3 p-3 my-4" onsubmit="return confirm('Confirm this purchase? The amount will be debited from your main wallet.')">@csrf<div class="d-flex flex-wrap align-items-end gap-3"><div><label class="form-label fw-bold">Quantity</label><input id="purchaseQuantity" type="number" class="form-control" style="width:110px" name="quantity" min="1" max="99" value="1" required></div><div><small class="text-muted">Main Wallet Balance</small><div class="fw-bold">₹{{ number_format(auth()->user()->main_wallet ?? 0, 2) }}</div></div><button class="btn btn-main ms-lg-auto"><i class="fa fa-cart-shopping me-1"></i> Purchase Now</button></div><small class="text-muted d-block mt-2">Total is calculated using the current retail price and debited immediately.</small></form>
      <div class="row g-3 detail-section"><div class="col-sm-6"><strong>HSN Code</strong><br>{{ $product->hsn_code ?: 'Not specified' }}</div><div class="col-sm-6"><strong>Refund Period</strong><br>{{ $product->refund_days ? $product->refund_days.' days' : 'Not available' }}</div><div class="col-sm-6"><strong>Variants</strong><br>{{ $product->has_variants ? 'Available' : 'No variants' }}</div>@if($product->seller)<div class="col-sm-6"><strong>Seller</strong><br>{{ $product->seller }}</div>@endif</div>
      @if($product->refund_description)<div class="detail-section"><h5>Refund Information</h5><p class="mb-0">{{ $product->refund_description }}</p></div>@endif
    </div>
    @if($product->full_description)<div class="col-12 detail-section"><h4>Product Description</h4><div class="text-muted" style="white-space:pre-line">{{ $product->full_description }}</div></div>@endif
  </div></div>
  @if($relatedProducts->isNotEmpty())<h4 class="fw-bold mt-5 mb-3">Related Products</h4><div class="row g-3">@foreach($relatedProducts as $related)<div class="col-sm-6 col-lg-3"><a class="text-decoration-none text-dark" href="{{ route('catalog.show',$related) }}"><div class="customer-panel h-100">@if($related->image)<img class="w-100 rounded mb-3" style="height:150px;object-fit:cover" src="{{ Storage::disk('public')->url($related->image) }}" alt="">@endif<strong>{{ $related->name }}</strong><div class="text-success mt-2">₹{{ number_format($related->retail_price,2) }}</div></div></a></div>@endforeach</div>@endif
</div>
@endsection
