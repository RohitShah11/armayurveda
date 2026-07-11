@extends('layouts.admin')

@section('title', 'Package Purchases')
@section('page-title', 'Package Purchases')

@section('content')
<div class="row g-4 mb-4">
  <div class="col-lg-4 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Total Purchases</p><h3>{{ $totalPurchases }}</h3></div>
        <i class="fa fa-box-open"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Completed</p><h3>{{ $completedPurchases }}</h3></div>
        <i class="fa fa-circle-check"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between">
        <div><p>Total Business</p><h3>INR {{ number_format($totalAmount, 2) }}</h3></div>
        <i class="fa fa-indian-rupee-sign"></i>
      </div>
    </div>
  </div>
</div>

<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.package-purchases.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-lg-3 col-md-6">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Member, mobile, ID or package">
      </div>
      <div class="col-lg-2 col-md-6">
        <label class="form-label">Package</label>
        <select name="package" class="form-select">
          <option value="">All Packages</option>
          @foreach($packageNames as $packageName)
            <option value="{{ $packageName }}" {{ request('package') === $packageName ? 'selected' : '' }}>{{ $packageName }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-lg-2 col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All Status</option>
          @foreach(['Completed', 'Pending', 'Failed', 'Cancelled'] as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-lg-2 col-md-6">
        <label class="form-label">From</label>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
      </div>
      <div class="col-lg-2 col-md-6">
        <label class="form-label">To</label>
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
      </div>
      <div class="col-lg-1 col-md-6 d-flex gap-2">
        <button class="btn btn-main flex-fill" title="Search"><i class="fa fa-search"></i></button>
        <a href="{{ route('admin.package-purchases.index') }}" class="btn btn-secondary" title="Reset"><i class="fa fa-rotate-left"></i></a>
      </div>
    </div>
  </form>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Package Purchase List</h5>
    <small class="text-muted">Showing {{ $purchases->firstItem() ?? 0 }} to {{ $purchases->lastItem() ?? 0 }} of {{ $purchases->total() }}</small>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Member</th>
          <th>Package</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Purchase Date</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>
        @forelse($purchases as $purchase)
          <tr>
            <td>{{ $loop->iteration + ($purchases->currentPage() - 1) * $purchases->perPage() }}</td>
            <td>
              <strong>{{ $purchase->user->name ?? '-' }}</strong><br>
              <small class="text-muted">{{ $purchase->user->member_id ?? '-' }} | {{ $purchase->user->mobile ?? '-' }}</small>
            </td>
            <td>
              <strong>{{ $purchase->package_name ?? $purchase->package->name ?? '-' }}</strong><br>
              <small class="text-muted">Package ID: {{ $purchase->package_id ?? '-' }}</small>
            </td>
            <td>INR {{ number_format($purchase->package_price, 2) }}</td>
            <td>
              @php
                $statusClass = match($purchase->status) {
                  'Completed' => 'bg-success',
                  'Pending' => 'bg-warning text-dark',
                  'Failed', 'Cancelled' => 'bg-danger',
                  default => 'bg-secondary',
                };
              @endphp
              <span class="badge {{ $statusClass }}">{{ $purchase->status ?? 'Pending' }}</span>
            </td>
            <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('d M Y h:i A') : '-' }}</td>
            <td>{{ optional($purchase->created_at)->format('d M Y') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No package purchases found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $purchases->links() }}</div>
</div>
@endsection
