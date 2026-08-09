@extends('layouts.auth')
@section('title','Login')
@section('content')
<div class="container auth-box">
  <div class="row w-100 justify-content-center">
    <div class="col-lg-10">
      <div class="card card-auth">
        <div class="row g-0">
          <div class="col-lg-5 left-panel">
            <img src="{{ asset('images/arm-ayurveda-logo.png') }}" class="logo mb-4" alt="ARM Ayurveda">
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
                <div class="input-group">
                  <input type="password" name="password" id="login_password" class="form-control" placeholder="Enter password" required>
                  <button type="button" id="login-password-toggle" class="btn btn-outline-secondary" aria-label="Show password" aria-pressed="false">
                    <svg class="password-eye-show" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 0 1 0-.64C3.42 7.51 7.35 4.5 12 4.5s8.58 3.01 9.96 7.18a1 1 0 0 1 0 .64C20.58 16.49 16.65 19.5 12 19.5S3.42 16.49 2.04 12.32Z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg class="password-eye-hide d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8M9.9 4.7A10.7 10.7 0 0 1 12 4.5c4.65 0 8.58 3.01 9.96 7.18a1 1 0 0 1 0 .64 11.7 11.7 0 0 1-2.08 3.76M6.61 6.61a11.8 11.8 0 0 0-4.57 5.07 1 1 0 0 0 0 .64C3.42 16.49 7.35 19.5 12 19.5c1.06 0 2.09-.16 3.05-.45"/>
                    </svg>
                  </button>
                </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const passwordInput = document.getElementById('login_password');
  const passwordToggle = document.getElementById('login-password-toggle');

  passwordToggle.addEventListener('click', () => {
    const isVisible = passwordInput.type === 'text';

    passwordInput.type = isVisible ? 'password' : 'text';
    passwordToggle.setAttribute('aria-label', `${isVisible ? 'Show' : 'Hide'} password`);
    passwordToggle.setAttribute('aria-pressed', String(! isVisible));
    passwordToggle.querySelector('.password-eye-show').classList.toggle('d-none', ! isVisible);
    passwordToggle.querySelector('.password-eye-hide').classList.toggle('d-none', isVisible);
  });
});
</script>
@endpush
