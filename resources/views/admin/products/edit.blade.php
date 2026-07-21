@extends('layouts.admin')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('content')<div class="admin-card"><form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update',$product) }}">@include('admin.products._form')</form></div>@endsection
