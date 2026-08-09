@extends('layouts.auth')
@section('title','Create Account')
@section('content')
<div class="container auth-box">
  <div class="row w-100 justify-content-center">
    <div class="col-lg-11">
      <div class="card card-auth">
        <div class="row g-0">
          <div class="col-lg-4 left-panel">
            <img src="{{ asset('images/arm-ayurveda-logo.png') }}" class="logo mb-4" alt="ARM Ayurveda">
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
                  <input
                    type="text"
                    name="sponsor_id"
                    id="sponsor_id"
                    class="form-control text-uppercase"
                    placeholder="Sponsor member ID"
                    value="{{ old('sponsor_id', request('sponsor')) }}"
                    autocomplete="off"
                    aria-describedby="sponsor-feedback"
                  >
                  <div id="sponsor-feedback" class="form-text" aria-live="polite"></div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Create password" required>
                    <button type="button" class="btn btn-outline-secondary password-toggle" data-target="password" aria-label="Show password" aria-pressed="false">
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
                <div class="col-md-6">
                  <label class="form-label">Confirm Password</label>
                  <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
                    <button type="button" class="btn btn-outline-secondary password-toggle" data-target="password_confirmation" aria-label="Show confirm password" aria-pressed="false">
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
                <div class="col-md-6">
                  <label class="form-label">State</label>
                  <input type="text" name="state" class="form-control" placeholder="Your state" value="{{ old('state') }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">City</label>
                  <input type="text" name="city" class="form-control" placeholder="Your city" value="{{ old('city') }}">
                </div>
                <div class="col-12">
                  <button id="register-submit" class="btn btn-main w-100">CREATE ACCOUNT</button>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.password-toggle').forEach((toggle) => {
    toggle.addEventListener('click', () => {
      const passwordInput = document.getElementById(toggle.dataset.target);
      const isVisible = passwordInput.type === 'text';
      const fieldName = toggle.dataset.target === 'password' ? 'password' : 'confirm password';

      passwordInput.type = isVisible ? 'password' : 'text';
      toggle.setAttribute('aria-label', `${isVisible ? 'Show' : 'Hide'} ${fieldName}`);
      toggle.setAttribute('aria-pressed', String(! isVisible));
      toggle.querySelector('.password-eye-show').classList.toggle('d-none', ! isVisible);
      toggle.querySelector('.password-eye-hide').classList.toggle('d-none', isVisible);
    });
  });

  const sponsorInput = document.getElementById('sponsor_id');
  const sponsorFeedback = document.getElementById('sponsor-feedback');
  const submitButton = document.getElementById('register-submit');
  const lookupUrl = @json(route('register.sponsor'));
  let lookupTimer;
  let lookupRequest;

  const showFeedback = (message = '', state = 'idle') => {
    sponsorFeedback.textContent = message;
    sponsorFeedback.classList.toggle('text-success', state === 'valid');
    sponsorFeedback.classList.toggle('text-danger', state === 'invalid');
    sponsorFeedback.classList.toggle('text-muted', state === 'checking');
    sponsorInput.classList.toggle('is-valid', state === 'valid');
    sponsorInput.classList.toggle('is-invalid', state === 'invalid');
    sponsorInput.setCustomValidity(state === 'invalid' ? message : '');
    submitButton.disabled = state === 'checking' || state === 'invalid';
  };

  const lookupSponsor = async () => {
    const memberId = sponsorInput.value.trim().toUpperCase();
    sponsorInput.value = memberId;

    if (! memberId) {
      lookupRequest?.abort();
      showFeedback();
      return;
    }

    lookupRequest?.abort();
    lookupRequest = new AbortController();
    showFeedback('Checking sponsor ID...', 'checking');

    try {
      const response = await fetch(`${lookupUrl}?member_id=${encodeURIComponent(memberId)}`, {
        headers: { 'Accept': 'application/json' },
        signal: lookupRequest.signal,
      });
      const data = await response.json();

      if (sponsorInput.value.trim().toUpperCase() !== memberId) {
        return;
      }

      if (! response.ok || ! data.available) {
        showFeedback(data.message || 'Sponsor is not available.', 'invalid');
        return;
      }

      showFeedback(`Sponsor: ${data.name}`, 'valid');
    } catch (error) {
      if (error.name !== 'AbortError') {
        showFeedback('Unable to check the sponsor right now. Please try again.', 'invalid');
      }
    }
  };

  sponsorInput.addEventListener('input', () => {
    clearTimeout(lookupTimer);
    lookupRequest?.abort();
    showFeedback(sponsorInput.value.trim() ? 'Checking sponsor ID...' : '', sponsorInput.value.trim() ? 'checking' : 'idle');
    lookupTimer = setTimeout(lookupSponsor, 400);
  });

  if (sponsorInput.value.trim()) {
    lookupSponsor();
  }
});
</script>
@endpush
