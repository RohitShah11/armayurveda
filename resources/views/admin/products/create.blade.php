@extends('layouts.admin')
@section('title', 'Add Product')
@section('page-title', 'Add Product')
@section('content')
@if($categories->isEmpty())<div class="alert alert-warning">Create an active category before adding a product. <a href="{{ route('admin.categories.create') }}">Add category</a></div>@endif
<div class="admin-card"><form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">@include('admin.products._form')</form></div>
@endsection
