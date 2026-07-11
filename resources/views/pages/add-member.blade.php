@extends('layouts.app')

@section('title', 'Add Member')
@section('page-title', 'Add Member')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.form-control,.form-select{height:48px;border-radius:12px}
textarea.form-control{height:90px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.info-card{border-left:5px solid var(--primary)}
.table thead th{background:var(--primary);color:#fff}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">
        <div class="card-box info-card">
            <h6>Your Member ID</h6>
            <h3 class="fw-bold text-primary">
                {{ $user->member_id }}
            </h3>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box info-card">
            <h6>Total Direct Members</h6>
            <h3 class="fw-bold text-success">
                {{ $totalDirect }}
            </h3>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box info-card">
            <h6>Active Package</h6>
            <h3 class="fw-bold">
                {{ $user->package_name ?? 'Not Purchased' }}
            </h3>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box info-card">
            <h6>Joining Link</h6>

            <button class="btn btn-gold btn-sm"
                    onclick="copyLink('{{ route('register', ['sponsor' => $user->member_id]) }}')">
                Copy Link
            </button>
        </div>
    </div>

</div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card-box">
          <h5 class="fw-bold mb-3">Register New Member</h5>

          <form action="{{ route('team.add-member.post') }}" method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Sponsor ID</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->member_id }}" disabled>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Enter full name"
                        value="{{ old('name') }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mobile Number</label>
                    <input
                        type="text"
                        name="mobile"
                        class="form-control"
                        placeholder="Enter mobile number"
                        value="{{ old('mobile') }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter email address"
                        value="{{ old('email') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Create password"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm password"
                        required>
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea
                        name="address"
                        class="form-control"
                        placeholder="Enter full address">{{ old('address') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">State</label>
                    <input
                        type="text"
                        name="state"
                        class="form-control"
                        placeholder="Enter state"
                        value="{{ old('state') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">PIN Code</label>
                    <input
                        type="text"
                        name="pin_code"
                        class="form-control"
                        placeholder="Enter PIN code"
                        value="{{ old('pin_code') }}">
                </div>

                <div class="col-12">
                    <label>
                        <input
                            type="checkbox"
                            required
                            {{ old('confirm') ? 'checked' : '' }}>
                        I confirm that all details are correct.
                    </label>
                </div>

                <div class="col-12 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-main">Add Member</button>
                    <button type="reset" class="btn btn-secondary rounded-pill px-4">Reset</button>
                </div>

            </div>
        </form>

        </div>
      </div>

      <div class="col-lg-4">
        <div class="card-box mb-4">
          <h5 class="fw-bold mb-3">Referral Link</h5>
          <p class="text-muted">Share this link with new members for direct joining.</p>
          <input type="text" class="form-control mb-3" id="refLink" value="https://armayurveda.com/signup.html?sponsor=ARM1001" readonly>
          <button class="btn btn-main w-100" onclick="copyLink()">Copy Referral Link</button>
        </div>

        <div class="card-box">
          <h5 class="fw-bold mb-3">Important Notes</h5>
          <ul class="mb-0">
            <li>Sponsor ID will be your member ID.</li>
            <li>New member can purchase Basic Package after login.</li>
            <li>Basic Package is required before Zenith Package.</li>
            <li>KYC can be completed after registration.</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="card-box mt-4">
        <h5 class="fw-bold mb-3">Recently Added Members</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Sponsor</th>
                        <th>Package</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($members as $member)

                        <tr>
                            <td>{{ $loop->iteration + ($members->firstItem() - 1) }}</td>

                            <td>{{ $member->created_at->format('d M Y') }}</td>

                            <td>{{ $member->member_id }}</td>

                            <td>{{ $member->name }}</td>

                            <td>{{ $member->mobile }}</td>

                            <td>{{ $member->sponsor_member_id }}</td>

                            <td>
                                {{ $member->package_name ?? 'Not Purchased' }}
                            </td>

                            <td>
                                @if($member->status == 'active')
                                    <span class="badge bg-success">Active</span>

                                @elseif($member->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>

                                @elseif($member->status == 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>

                                @else
                                    <span class="badge bg-danger">{{ ucfirst($member->status) }}</span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                No members found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="mt-3">
                {{ $members->links() }}
            </div>
        @endif
    </div>

  </div>
@endsection
