@extends('layouts.admin')
@section('title', 'Add Category')
@section('page-title', 'Add Category')
@section('content')<div class="admin-card"><form method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.store') }}">@include('admin.categories._form')</form></div>@endsection
