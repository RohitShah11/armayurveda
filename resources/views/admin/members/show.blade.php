@extends('layouts.admin')

@section('title', 'Member Details')
@section('page-title', 'Member Details')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
  <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
    <i class="fa fa-arrow-left me-1"></i> Back
  </a>
  <span class="badge bg-dark">{{ $member->status ?? 'Active' }}</span>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="admin-card mb-4">
      <h5 class="fw-bold mb-3">Profile</h5>
      <div class="detail-row"><b>Name</b><span>{{ $member->name }}</span></div>
      <div class="detail-row"><b>Member ID</b><span>{{ $member->member_id ?? '-' }}</span></div>
      <div class="detail-row"><b>Email</b><span>{{ $member->email ?? '-' }}</span></div>
      <div class="detail-row"><b>Mobile</b><span>{{ $member->mobile ?? '-' }}</span></div>
      <div class="detail-row"><b>Sponsor ID</b><span>{{ $member->sponsor_id ?? '-' }}</span></div>
      <div class="detail-row"><b>Package</b><span>{{ $member->package_name ?? '-' }}</span></div>
      <div class="detail-row"><b>Main Wallet</b><span>INR {{ number_format($member->main_wallet ?? 0, 2) }}</span></div>
      <div class="detail-row"><b>Joined</b><span>{{ optional($member->created_at)->format('d M Y h:i A') ?? '-' }}</span></div>
    </div>

    <div class="admin-card">
      <h5 class="fw-bold mb-3">Recent Fund Requests</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead><tr><th>Date</th><th>Amount</th><th>Txn ID</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($member->fundRequests as $fund)
              <tr>
                <td>{{ optional($fund->created_at)->format('d M Y') ?? '-' }}</td>
                <td>INR {{ number_format($fund->amount, 2) }}</td>
                <td>{{ $fund->transaction_id ?? '-' }}</td>
                <td><span class="badge bg-secondary">{{ $fund->status ?? 'Pending' }}</span></td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center py-4">No fund requests found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="admin-card mb-4">
      <h5 class="fw-bold mb-3">KYC Summary</h5>
      <div class="detail-row"><b>Status</b><span>{{ $member->kyc->status ?? 'Not Submitted' }}</span></div>
      <div class="detail-row"><b>PAN</b><span>{{ $member->kyc->pan_number ?? '-' }}</span></div>
      <div class="detail-row"><b>Aadhaar</b><span>{{ $member->kyc->aadhaar_number ?? '-' }}</span></div>
      <div class="detail-row"><b>Bank</b><span>{{ $member->kyc->bank_name ?? '-' }}</span></div>
      <a href="{{ route('admin.kyc.index', ['search' => $member->member_id]) }}" class="btn btn-main w-100 mt-3">Open KYC</a>
    </div>

    <div class="admin-card mb-4">
      <h5 class="fw-bold mb-3">Update Status</h5>
      <form method="POST" action="{{ route('admin.members.status', $member) }}">
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            @foreach(['Active', 'Inactive', 'Blocked'] as $status)
              <option value="{{ $status }}" {{ ($member->status ?? 'Active') === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-main w-100">Save Status</button>
      </form>
    </div>

    <div class="admin-card">
      <h5 class="fw-bold mb-3">Reset Password</h5>
      <form method="POST" action="{{ route('admin.members.password', $member) }}">
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-main w-100">Reset Password</button>
      </form>
    </div>
  </div>
</div>
@endsection
