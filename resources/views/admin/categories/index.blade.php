@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Category List')
@section('content')
<div class="admin-card">
  <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <form class="d-flex gap-2" method="GET">
      <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by category name...">
      <button class="btn btn-outline-dark">Search</button>
    </form>
    <a class="btn btn-main align-self-start" href="{{ route('admin.categories.create') }}"><i class="fa fa-plus me-1"></i> Add Category</a>
  </div>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Parent</th><th>Products</th><th>Status</th><th>Updated</th><th>Action</th></tr></thead>
      <tbody>
      @forelse($categories as $category)
        <tr>
          <td>{{ $categories->firstItem() + $loop->index }}</td>
          <td>@if($category->image)<img class="proof-thumb" src="{{ Storage::url($category->image) }}" alt="">@else<span class="text-muted">—</span>@endif</td>
          <td class="fw-semibold">{{ $category->name }}</td><td>{{ $category->parent?->name ?? '—' }}</td><td>{{ $category->products_count }}</td>
          <td><span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>{{ $category->updated_at->format('d M, Y') }}</td>
          <td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.edit', $category) }}"><i class="fa fa-pen"></i></a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button></form></div></td>
        </tr>
      @empty<tr><td colspan="8" class="text-center py-4 text-muted">No categories found.</td></tr>@endforelse
      </tbody>
    </table>
  </div>
  {{ $categories->links() }}
</div>
@endsection
