@extends('layouts.admin')

@section('title', 'Fund Requests')
@section('page-title', 'Fund Requests')

@section('content')
<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.funds.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Member, transaction ID or depositor">
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All</option>
          @foreach(['Pending', 'Approved', 'Rejected'] as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
        <a href="{{ route('admin.funds.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Fund Request List</h5>
    <small class="text-muted">Showing {{ $funds->firstItem() ?? 0 }} to {{ $funds->lastItem() ?? 0 }} of {{ $funds->total() }}</small>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Member</th>
          <th>Amount</th>
          <th>Payment</th>
          <th>Transaction ID</th>
          <th>Proof</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($funds as $fund)
          <tr>
            <td>
              <strong>{{ $fund->user->name ?? '-' }}</strong><br>
              <small class="text-muted">{{ $fund->user->member_id ?? '-' }}</small>
            </td>
            <td>INR {{ number_format($fund->amount, 2) }}</td>
            <td>{{ $fund->payment_mode ?? '-' }}</td>
            <td>{{ $fund->transaction_id ?? '-' }}</td>
            <td>
              @if($fund->payment_proof)
                <a href="{{ asset($fund->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-dark">Open</a>
              @else
                -
              @endif
            </td>
            <td><span class="badge bg-secondary">{{ $fund->status ?? 'Pending' }}</span></td>
            <td>{{ optional($fund->created_at)->format('d M Y') ?? '-' }}</td>
            <td>
              <button class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#fundModal{{ $fund->id }}">Review</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center py-4">No fund requests found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $funds->links() }}</div>
</div>

@foreach($funds as $fund)
  @php
    $proofExtension = $fund->payment_proof ? strtolower(pathinfo($fund->payment_proof, PATHINFO_EXTENSION)) : null;
  @endphp
  <div class="modal fade" id="fundModal{{ $fund->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content rounded-4">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Review Fund Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-4">
            <div class="col-md-7">
              <div class="detail-row"><b>Member</b><span>{{ $fund->user->name ?? '-' }}</span></div>
              <div class="detail-row"><b>Member ID</b><span>{{ $fund->user->member_id ?? '-' }}</span></div>
              <div class="detail-row"><b>Amount</b><span>INR {{ number_format($fund->amount, 2) }}</span></div>
              <div class="detail-row"><b>Payment Mode</b><span>{{ $fund->payment_mode ?? '-' }}</span></div>
              <div class="detail-row"><b>Transaction ID</b><span>{{ $fund->transaction_id ?? '-' }}</span></div>
              <div class="detail-row"><b>Depositor</b><span>{{ $fund->depositor_name ?? '-' }}</span></div>
              <div class="detail-row"><b>Payment Date</b><span>{{ $fund->payment_date ? \Carbon\Carbon::parse($fund->payment_date)->format('d M Y') : '-' }}</span></div>
              <div class="detail-row"><b>Member Remark</b><span>{{ $fund->remark ?? '-' }}</span></div>
              <div class="detail-row"><b>Current Status</b><span>{{ $fund->status ?? 'Pending' }}</span></div>
              <div class="detail-row"><b>Admin Remark</b><span>{{ $fund->admin_remark ?? '-' }}</span></div>
            </div>
            <div class="col-md-5">
              <h6 class="fw-bold">Payment Proof</h6>
              @if($fund->payment_proof)
                @if(in_array($proofExtension, ['jpg', 'jpeg', 'png', 'webp']))
                  <img src="{{ asset($fund->payment_proof) }}" class="img-fluid rounded border mb-3" alt="Payment proof">
                @else
                  <div class="p-5 text-center bg-light rounded mb-3"><i class="fa fa-file-pdf fa-3x"></i></div>
                @endif
                <a href="{{ asset($fund->payment_proof) }}" target="_blank" class="btn btn-outline-dark w-100">Open Proof</a>
              @else
                <div class="text-muted">No proof uploaded.</div>
              @endif
            </div>
          </div>

          <form method="POST" action="{{ route('admin.funds.update', $fund) }}" class="mt-4">
            @csrf
            @method('PATCH')
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Decision</label>
                <select name="status" class="form-select" required>
                  <option value="Approved">Approve and Credit Wallet</option>
                  <option value="Rejected">Reject</option>
                </select>
              </div>
              <div class="col-md-8">
                <label class="form-label">Admin Remark</label>
                <input type="text" name="admin_remark" class="form-control" placeholder="Optional admin remark" value="{{ $fund->admin_remark }}">
              </div>
              <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-main px-4">Submit Decision</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection
