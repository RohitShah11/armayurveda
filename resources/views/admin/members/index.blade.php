@extends('layouts.admin')

@section('title', 'Members')
@section('page-title', 'Members')

@section('content')
<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.members.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, member ID, mobile or email">
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All</option>
          @foreach(['Active', 'Inactive', 'Blocked'] as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Member List</h5>
    <small class="text-muted">Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() }}</small>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Member</th>
          <th>Contact</th>
          <th>Sponsor</th>
          <th>Package</th>
          <th>Main Wallet</th>
          <th>KYC</th>
          <th>Status</th>
          <th>Joined</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($members as $member)
          <tr>
            <td>
              <strong>{{ $member->name }}</strong><br>
              <small class="text-muted">{{ $member->member_id ?? '-' }}</small>
            </td>
            <td>{{ $member->mobile ?? '-' }}<br><small class="text-muted">{{ $member->email ?? '-' }}</small></td>
            <td>{{ $member->sponsor_id ?? '-' }}</td>
            <td>{{ $member->package_name ?? '-' }}</td>
            <td>INR {{ number_format($member->main_wallet ?? 0, 2) }}</td>
            <td><span class="badge bg-secondary">{{ $member->kyc->status ?? 'Not Submitted' }}</span></td>
            <td><span class="badge bg-dark">{{ $member->status ?? 'Active' }}</span></td>
            <td>{{ optional($member->created_at)->format('d M Y') ?? '-' }}</td>
            <td><a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-main">Manage</a></td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center py-4">No members found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $members->links() }}</div>
</div>
@endsection
