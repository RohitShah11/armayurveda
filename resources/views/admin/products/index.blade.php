@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Product List')
@section('content')
<div class="admin-card">
  <form method="GET" class="row g-2 mb-4"><div class="col-md-5"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Name, brand or HSN code..."></div><div class="col-md-3"><select class="form-select" name="category_id"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id')==$category->id)>{{ $category->name }}</option>@endforeach</select></div><div class="col-auto"><button class="btn btn-outline-dark">Filter</button></div><div class="col-md text-md-end"><a class="btn btn-main" href="{{ route('admin.products.create') }}"><i class="fa fa-plus me-1"></i> Add Product</a></div></form>
  <div class="table-responsive"><table class="table align-middle"><thead><tr><th>#</th><th>Image</th><th>Product</th><th>Category</th><th>MRP</th><th>Retail Price</th><th>Status</th><th>Action</th></tr></thead><tbody>
  @forelse($products as $product)<tr><td>{{ $products->firstItem()+$loop->index }}</td><td>@if($product->image)<img class="proof-thumb" src="{{ Storage::disk('public')->url($product->image) }}" alt="">@else—@endif</td><td><strong>{{ $product->name }}</strong><br><small class="text-muted">{{ $product->brand ?: $product->hsn_code }}</small></td><td>{{ $product->category->name }}</td><td>₹{{ number_format($product->mrp, 2) }}</td><td>₹{{ number_format($product->retail_price, 2) }}</td><td><span class="badge {{ $product->is_active?'bg-success':'bg-secondary' }}">{{ $product->is_active?'Active':'Inactive' }}</span></td><td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.edit',$product) }}"><i class="fa fa-pen"></i></a><form method="POST" action="{{ route('admin.products.destroy',$product) }}" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button></form></div></td></tr>
  @empty<tr><td colspan="8" class="text-center py-4 text-muted">No products found.</td></tr>@endforelse
  </tbody></table></div>{{ $products->links() }}
</div>
@endsection
