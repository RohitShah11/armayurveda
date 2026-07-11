@extends('layouts.auth')
@section('title','Create Account')
@section('content')
<div class="container auth-box">
  <div class="row w-100 justify-content-center">
    <div class="col-lg-11">
      <div class="card card-auth">
        <div class="row g-0">
          <div class="col-lg-4 left-panel">
            <img src="{{ asset('images/logo.jpeg') }}" class="logo mb-4">
            <h2>Join ARM Ayurveda</h2>
            <p>Register to start your wellness journey and build your business network.</p>
          </div>
          <div class="col-lg-8 p-5 bg-white">
            <h3 class="fw-bold mb-2">Create Account</h3>
            <p class="text-muted mb-4">Fill in your details to register.</p>
            @if($errors->any())
              <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <form method="POST" action="{{ route('register.post') }}">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Mobile Number</label>
                  <input type="text" name="mobile" class="form-control" placeholder="10-digit mobile" value="{{ old('mobile') }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Sponsor ID</label>
                  <input type="text" name="sponsor_id" class="form-control" placeholder="Sponsor member ID" value="{{ old('sponsor_id') }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Create password" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">State</label>
                  <input type="text" name="state" class="form-control" placeholder="Your state" value="{{ old('state') }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">City</label>
                  <input type="text" name="city" class="form-control" placeholder="Your city" value="{{ old('city') }}">
                </div>
                <div class="col-12">
                  <button class="btn btn-main w-100">CREATE ACCOUNT</button>
                </div>
                <p class="text-center mt-2">Already registered? <a href="{{ route('login') }}">Login here</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection