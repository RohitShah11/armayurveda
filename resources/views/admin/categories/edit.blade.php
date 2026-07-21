@extends('layouts.admin')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('content')<div class="admin-card"><form method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.update', $category) }}">@include('admin.categories._form')</form></div>@endsection
