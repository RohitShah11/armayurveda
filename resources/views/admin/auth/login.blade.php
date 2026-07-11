@extends('layouts.auth')
@push('styles')
<style>
/* Left Panel */
.left-panel{
    background:
        linear-gradient(rgba(0,0,0,.90), rgba(0,0,0,.90)),
        url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80');
    background-size: cover;
    /*background-position: center;*/
    color: #fff;
    padding: 50px;
}

/* Admin Login Button */
.btn-main{
    background:#000;
    color:#fff;
    border:none;
    border-radius:30px;
    padding:12px;
    font-weight:700;
    transition:.3s;
}

.btn-main:hover{
    background:#222;
    color:#fff;
}

/* Links */
a{
    color:#000;
    font-weight:600;
    text-decoration:none;
}

a:hover{
    color:#444;
}

/* Inputs */
.form-control{
    height:48px;
    border-radius:12px;
}

.form-control:focus{
    border-color:#000;
    box-shadow:0 0 0 .2rem rgba(0,0,0,.15);
}

/* Labels */
.form-label{
    font-weight:600;
}
</style>
@endpush

@section('title', 'Admin Login')

@section('content')
<div class="container auth-box">
  <div class="row w-100 justify-content-center">
    <div class="col-lg-10">
      <div class="card card-auth">
        <div class="row g-0">
          <div class="col-lg-5 left-panel">
            <img src="{{ asset('images/logo.jpeg') }}" class="logo mb-4" alt="ARM Ayurveda">
            <h2>Admin Panel</h2>
            <p>Login to manage members, KYC approvals, fund requests and business operations.</p>
          </div>
          <div class="col-lg-7 p-5 bg-white">
            <h3 class="fw-bold mb-2">Admin Login</h3>
            <p class="text-muted mb-4">Enter your admin email/mobile and password.</p>

            @if($errors->any())
              <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Email / Mobile</label>
                <input type="text" name="login" class="form-control" placeholder="Enter admin email or mobile" value="{{ old('login') }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
              </div>
              <div class="d-flex justify-content-between mb-4">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="{{ route('login') }}">Member Login</a>
              </div>
              <button class="btn btn-main w-100">LOGIN AS ADMIN</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
