@extends('layouts.app')
@section('title', 'Repurchase')
@section('page-title', 'Repurchase Categories')
@push('styles')
<style>
.category-card{display:block;background:#fff;border:1px solid #eee;border-radius:16px;overflow:hidden;height:100%;color:#212529;text-decoration:none;box-shadow:0 7px 22px rgba(0,0,0,.06);transition:.2s}.category-card:hover{color:var(--primary);transform:translateY(-4px);box-shadow:0 12px 30px rgba(0,0,0,.1)}
.category-image{height:210px;width:100%;object-fit:cover;background:#f3f4f6}.category-placeholder{height:210px;display:flex;align-items:center;justify-content:center;background:#f3f4f6;color:#9ca3af;font-size:44px}.category-body{padding:20px}.subcategory-link{display:inline-block;margin:4px 3px 0 0;padding:5px 10px;border-radius:18px;background:var(--light);color:var(--primary);text-decoration:none;font-size:12px}.subcategory-link:hover{background:var(--primary);color:#fff}
</style>
@endpush
@section('content')
<div class="container-fluid py-4">
  <div class="mb-4"><h4 class="fw-bold mb-1">Choose a category</h4><p class="text-muted mb-0">Select a category to view products available for repurchase.</p></div>
  <div class="row g-4">
    @forelse($categories as $category)
      <div class="col-sm-6 col-xl-3"><div class="category-card">
        <a href="{{ route('catalog.category', $category) }}" class="text-decoration-none text-dark d-block">
          @if($category->image)<img class="category-image" src="{{ Storage::disk('public')->url($category->image) }}" alt="{{ $category->name }}">@else<div class="category-placeholder"><i class="fa fa-layer-group"></i></div>@endif
        </a>
        <div class="category-body"><a href="{{ route('catalog.category', $category) }}" class="text-decoration-none text-dark"><h5 class="fw-bold">{{ $category->name }}</h5></a><p class="text-muted small mb-2">{{ $category->products_count }} direct {{ Str::plural('product', $category->products_count) }}</p>
        @if($category->children->isNotEmpty())<div>@foreach($category->children as $child)<a class="subcategory-link" href="{{ route('catalog.category', $child) }}">{{ $child->name }} ({{ $child->products_count }})</a>@endforeach</div>@endif
          </div>
      </div></div>
    @empty
      <div class="col-12"><div class="alert alert-light text-center py-5"><i class="fa fa-layer-group fa-3x text-muted mb-3"></i><h5>No categories available</h5><p class="text-muted mb-0">Categories added by the admin will appear here.</p></div></div>
    @endforelse
  </div>
</div>
@endsection
