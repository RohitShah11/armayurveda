@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Total Members</p><h3>{{ $totalMembers }}</h3></div>
        <i class="fa fa-users"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Active Members</p><h3>{{ $activeMembers }}</h3></div>
        <i class="fa fa-user-check"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Pending KYC</p><h3>{{ $pendingKyc }}</h3></div>
        <i class="fa fa-id-card"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Pending Funds</p><h3>{{ $pendingFunds }}</h3></div>
        <i class="fa fa-wallet"></i>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-4">
    <div class="admin-card h-100">
      <p class="text-muted mb-1">Approved Fund Amount</p>
      <h3 class="fw-bold mb-3">INR {{ number_format($approvedFundAmount, 2) }}</h3>
      <a href="{{ route('admin.funds.index', ['status' => 'Pending']) }}" class="btn btn-main">Review Funds</a>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="admin-card h-100">
      <p class="text-muted mb-1">KYC Queue</p>
      <h3 class="fw-bold mb-3">{{ $pendingKyc }} Pending</h3>
      <a href="{{ route('admin.kyc.index', ['status' => 'Pending']) }}" class="btn btn-main">Review KYC</a>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="admin-card h-100">
      <p class="text-muted mb-1">Member Directory</p>
      <h3 class="fw-bold mb-3">{{ $totalMembers }} Records</h3>
      <a href="{{ route('admin.members.index') }}" class="btn btn-main">Open Members</a>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="admin-card">
      <h5 class="fw-bold mb-3">Recent Members</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead><tr><th>Member</th><th>Mobile</th><th>Status</th><th></th></tr></thead>
          <tbody>
            @forelse($recentMembers as $member)
              <tr>
                <td>{{ $member->name }}<br><small class="text-muted">{{ $member->member_id ?? '-' }}</small></td>
                <td>{{ $member->mobile ?? '-' }}</td>
                <td><span class="badge bg-secondary">{{ $member->status ?? 'Active' }}</span></td>
                <td><a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-outline-dark">View</a></td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center py-4">No members found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="admin-card">
      <h5 class="fw-bold mb-3">Recent Fund Requests</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead><tr><th>Member</th><th>Amount</th><th>Status</th><th></th></tr></thead>
          <tbody>
            @forelse($recentFunds as $fund)
              <tr>
                <td>{{ $fund->user->name ?? '-' }}<br><small class="text-muted">{{ $fund->transaction_id ?? '-' }}</small></td>
                <td>INR {{ number_format($fund->amount, 2) }}</td>
                <td><span class="badge bg-secondary">{{ $fund->status ?? 'Pending' }}</span></td>
                <td><a href="{{ route('admin.funds.index', ['search' => $fund->transaction_id]) }}" class="btn btn-sm btn-outline-dark">Review</a></td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center py-4">No fund requests found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
