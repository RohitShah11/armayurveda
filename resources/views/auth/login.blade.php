@extends('layouts.auth')
@section('title','Login')
@section('content')
<div class="container auth-box">
  <div class="row w-100 justify-content-center">
    <div class="col-lg-10">
      <div class="card card-auth">
        <div class="row g-0">
          <div class="col-lg-5 left-panel">
            <img src="{{ asset('images/logo.jpeg') }}" class="logo mb-4">
            <h2>Welcome Back</h2>
            <p>Login to manage your ARM Ayurveda account, orders and business dashboard.</p>
          </div>
          <div class="col-lg-7 p-5 bg-white">
            <h3 class="fw-bold mb-2">Login Account</h3>
            <p class="text-muted mb-4">Enter your mobile/email and password.</p>
            @if($errors->any())
              <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Mobile / Email</label>
                <input type="text" name="login" class="form-control" placeholder="Enter mobile or email" value="{{ old('login') }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
              </div>
              <div class="d-flex justify-content-between mb-4">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot Password?</a>
              </div>
              <button class="btn btn-main w-100">LOGIN</button>
              <p class="text-center mt-4">New user? <a href="{{ route('register') }}">Create Account</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection