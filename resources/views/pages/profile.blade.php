@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.profile-cover{background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:18px;padding:35px;color:#fff}
.profile-img{width:110px;height:110px;border-radius:50%;border:5px solid #fff;object-fit:cover}
.status-badge{background:#fff3cd;color:#856404;padding:6px 14px;border-radius:20px;font-weight:700;font-size:13px}
.info-row{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:12px 0}
.info-row span:first-child{font-weight:700;color:#555}
.form-control,.form-select{height:48px;border-radius:12px}
textarea.form-control{height:90px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
@media(max-width:991px){}
@media(max-width:576px){.page-.profile-cover{text-align:center}.info-row{display:block}}
</style>
@endpush

@section('content')
    <div class="profile-cover mb-4">
        <div class="row align-items-center g-3">
            <div class="col-md-2 text-center">

                @if(!empty($profile) && !empty($profile->profile_photo))
                    <img src="{{ asset($profile->profile_photo) }}" class="profile-img" alt="Profile">
                @else
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="profile-img" alt="Profile">
                @endif

            </div>

            <div class="col-md-7">
                <h3 class="fw-bold mb-1">{{ $user->name }}</h3>

                <p class="mb-1">
                    <strong>Member ID:</strong> {{ $user->member_id ?? 'N/A' }}
                    |
                    <strong>Sponsor ID:</strong> {{ $user->sponsor_id ?? 'N/A' }}
                </p>

                <p class="mb-0">
                    <strong>Joined:</strong> {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                    |
                    <strong>Package:</strong> {{ $user->package_name ?? 'No Package' }}
                </p>
            </div>

            <div class="col-md-3 text-md-end">

                @php
                    $kycStatus = $user->kyc_status ?? 'Pending';
                @endphp

                @if($kycStatus == 'Approved')
                    <span class="badge bg-success px-3 py-2">
                        KYC Approved
                    </span>
                @elseif($kycStatus == 'Rejected')
                    <span class="badge bg-danger px-3 py-2">
                        KYC Rejected
                    </span>
                @else
                    <span class="status-badge">
                        KYC Pending
                    </span>
                @endif

                <div class="mt-3">
                    <a href="{{ route('profile.id-card') }}" class="btn btn-light fw-bold rounded-pill px-4">
                        <i class="fa-solid fa-id-card me-2"></i>View ID Card
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-5">
            <div class="card-box">

                <h5 class="fw-bold mb-3">Profile Details</h5>

                <div class="info-row">
                    <span>Full Name</span>
                    <span>{{ $user->name }}</span>
                </div>

                <div class="info-row">
                    <span>Mobile</span>
                    <span>{{ $user->mobile ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Email</span>
                    <span>{{ $user->email }}</span>
                </div>

                <div class="info-row">
                    <span>Date of Birth</span>
                    <span>
                        {{ !empty($profile->dob) ? \Carbon\Carbon::parse($profile->dob)->format('d M Y') : '-' }}
                    </span>
                </div>

                <div class="info-row">
                    <span>Gender</span>
                    <span>{{ $profile->gender ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Address</span>
                    <span>{{ $profile->address ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>State</span>
                    <span>{{ $profile->state ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>PIN Code</span>
                    <span>{{ $profile->pincode ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Nominee</span>
                    <span>{{ $profile->nominee_name ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Nominee Relation</span>
                    <span>{{ $profile->nominee_relation ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Status</span>

                    @if(($user->status ?? '') == 'Active')
                        <span class="text-success fw-bold">Active</span>
                    @else
                        <span class="text-danger fw-bold">
                            {{ $user->status ?? 'Inactive' }}
                        </span>
                    @endif
                </div>

            </div>
        </div>

      <div class="col-lg-7">
        <div class="card-box">
            <h5 class="fw-bold mb-3">Edit Profile</h5>


            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile Number</label>
                        <input
                            type="text"
                            name="mobile"
                            class="form-control @error('mobile') is-invalid @enderror"
                            value="{{ old('mobile', $user->mobile ?? '') }}">

                        @error('mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input
                            type="date"
                            name="dob"
                            class="form-control @error('dob') is-invalid @enderror"
                            value="{{ old('dob', $profile->dob ?? '') }}">

                        @error('dob')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>

                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">

                            <option value="">Select Gender</option>

                            <option value="Male"
                                {{ old('gender', $profile->gender ?? '') == 'Male' ? 'selected' : '' }}>
                                Male
                            </option>

                            <option value="Female"
                                {{ old('gender', $profile->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                Female
                            </option>

                            <option value="Other"
                                {{ old('gender', $profile->gender ?? '') == 'Other' ? 'selected' : '' }}>
                                Other
                            </option>

                        </select>

                        @error('gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Profile Photo</label>

                        <input
                            type="file"
                            name="profile_photo"
                            class="form-control @error('profile_photo') is-invalid @enderror">

                        @error('profile_photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Full Address</label>

                        <textarea
                            name="address"
                            class="form-control @error('address') is-invalid @enderror"
                            rows="3">{{ old('address', $profile->address ?? '') }}</textarea>

                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">State</label>

                        <input
                            type="text"
                            name="state"
                            class="form-control @error('state') is-invalid @enderror"
                            value="{{ old('state', $profile->state ?? '') }}">

                        @error('state')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">PIN Code</label>

                        <input
                            type="text"
                            name="pincode"
                            class="form-control @error('pincode') is-invalid @enderror"
                            value="{{ old('pincode', $profile->pincode ?? '') }}">

                        @error('pincode')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nominee Name</label>

                        <input
                            type="text"
                            name="nominee_name"
                            class="form-control @error('nominee_name') is-invalid @enderror"
                            value="{{ old('nominee_name', $profile->nominee_name ?? '') }}">

                        @error('nominee_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nominee Relation</label>

                        <input
                            type="text"
                            name="nominee_relation"
                            class="form-control @error('nominee_relation') is-invalid @enderror"
                            value="{{ old('nominee_relation', $profile->nominee_relation ?? '') }}">

                        @error('nominee_relation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-main">
                            Update Profile
                        </button>

                        <button type="reset" class="btn btn-secondary rounded-pill px-4">
                            Reset
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="row g-4 mt-1">
      <div class="col-lg-6">
          <div class="card-box">
            <h5 class="fw-bold mb-3">Bank Details Preview</h5>
            
            <div class="info-row">
              <span>Account Holder</span>
              <span>{{ $user->kyc ? $user->kyc->account_holder_name : 'Not Provided' }}</span>
            </div>
            
            <div class="info-row">
              <span>Account Number</span>
              <span>{{ $user->kyc ? $user->kyc->account_number : 'Not Provided' }}</span>
            </div>
            
            <div class="info-row">
              <span>IFSC Code</span>
              <span>{{ $user->kyc ? $user->kyc->ifsc_code : 'Not Provided' }}</span>
            </div>
            
            <a href="{{ route('kyc') }}" class="btn btn-gold mt-3">Update KYC / Bank</a>
          </div>
        </div>

      <div class="col-lg-6">
        <div class="card-box">

            <h5 class="fw-bold mb-3">Account Information</h5>

            <div class="info-row">
                <span>Member ID</span>
                <span>{{ $user->member_id }}</span>
            </div>

            <div class="info-row">
                <span>Sponsor ID</span>
                <span>{{ $user->sponsor_id ?? '-' }}</span>
            </div>

            <div class="info-row">
                <span>Package</span>
                <span>{{ $user->package_name ?? 'No Package' }}</span>
            </div>

            <div class="info-row">
                <span>Joining Date</span>
                <span>{{ $user->created_at->format('d M Y') }}</span>
            </div>

            <a href="{{ route('change.password') }}" class="btn btn-main mt-3">
                Change Password
            </a>

        </div>
    </div>

    </div>

  </div>
@endsection
