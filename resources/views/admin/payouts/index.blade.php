@extends('layouts.admin')

@section('title', 'Payout Requests')
@section('page-title', 'Payout Requests')

@section('content')
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted mb-1">Total Requests</p><h3 class="fw-bold mb-0">{{ number_format($totalRequests) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted mb-1">Pending Requests</p><h3 class="fw-bold text-warning mb-0">{{ number_format($pendingRequests) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted mb-1">Pending Amount</p><h3 class="fw-bold text-warning mb-0">₹{{ number_format($pendingAmount, 2) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted mb-1">Total Paid</p><h3 class="fw-bold text-success mb-0">₹{{ number_format($paidAmount, 2) }}</h3></div></div>
</div>

<div class="alert alert-info rounded-4">
  Payout amounts are reserved from the member's earning wallet when submitted. Approving records the external payment; rejecting returns the amount to the member's wallet.
</div>

<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.payouts.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6"><label class="form-label">Search</label><input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Member, request or payment transaction ID"></div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select"><option value="">All</option>@foreach(['Pending', 'Approved', 'Rejected'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select>
      </div>
      <div class="col-md-3 d-flex gap-2"><button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button><a href="{{ route('admin.payouts.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a></div>
    </div>
  </form>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h5 class="fw-bold mb-0">Member Payout Requests</h5><small class="text-muted">Showing {{ $payouts->firstItem() ?? 0 }} to {{ $payouts->lastItem() ?? 0 }} of {{ $payouts->total() }}</small></div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Request</th><th>Member</th><th>Amount</th><th>Mode</th><th>Eligibility at Review</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($payouts as $payout)
          @php($badge = match($payout->status) {'Approved' => 'success', 'Rejected' => 'danger', default => 'warning'})
          <tr>
            <td><strong>{{ $payout->request_no }}</strong></td>
            <td><strong>{{ $payout->user->name ?? '-' }}</strong><br><small class="text-muted">{{ $payout->user->member_id ?? '-' }}</small></td>
            <td>₹{{ number_format((float) $payout->amount, 2) }}</td>
            <td>{{ $payout->mode }}</td>
            <td>
              <span class="badge {{ filled($payout->user?->package_name) ? 'bg-success' : 'bg-danger' }}">Package</span>
              <span class="badge {{ $payout->user?->kyc?->status === 'Approved' ? 'bg-success' : 'bg-danger' }}">KYC {{ $payout->user?->kyc?->status ?? 'Missing' }}</span>
            </td>
            <td><span class="badge bg-{{ $badge }}">{{ $payout->status }}</span>@if($payout->refunded_at)<br><small class="text-success">Refunded</small>@endif</td>
            <td>{{ $payout->created_at?->format('d M Y, h:i A') }}</td>
            <td><button class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#payoutModal{{ $payout->id }}">{{ $payout->status === 'Pending' ? 'Review' : 'Details' }}</button></td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center py-5 text-muted">No payout requests found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $payouts->links() }}</div>
</div>

@foreach($payouts as $payout)
<div class="modal fade" id="payoutModal{{ $payout->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content rounded-4">
    <div class="modal-header"><h5 class="modal-title fw-bold">Payout {{ $payout->request_no }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
      <div class="row g-4">
        <div class="col-md-6">
          <h6 class="fw-bold">Request Details</h6>
          <div class="detail-row"><b>Member</b><span>{{ $payout->user->name ?? '-' }} ({{ $payout->user->member_id ?? '-' }})</span></div>
          <div class="detail-row"><b>Amount</b><span>₹{{ number_format((float) $payout->amount, 2) }}</span></div>
          <div class="detail-row"><b>Charge</b><span>₹{{ number_format((float) $payout->charge, 2) }}</span></div>
          <div class="detail-row"><b>Net Payable</b><span>₹{{ number_format((float) $payout->net_amount, 2) }}</span></div>
          <div class="detail-row"><b>Mode</b><span>{{ $payout->mode }}</span></div>
          @if($payout->mode === 'UPI')<div class="detail-row"><b>UPI ID</b><span>{{ $payout->upi_id }}</span></div>@endif
          <div class="detail-row"><b>Member Remark</b><span>{{ $payout->member_remark ?? '-' }}</span></div>
        </div>
        <div class="col-md-6">
          <h6 class="fw-bold">Captured Payment Details</h6>
          <div class="detail-row"><b>Account Holder</b><span>{{ $payout->account_holder_name ?? '-' }}</span></div>
          <div class="detail-row"><b>Bank</b><span>{{ $payout->bank_name ?? '-' }}</span></div>
          <div class="detail-row"><b>Account Number</b><span>{{ $payout->account_number ?? '-' }}</span></div>
          <div class="detail-row"><b>IFSC</b><span>{{ $payout->ifsc_code ?? '-' }}</span></div>
          <div class="detail-row"><b>Current Status</b><span>{{ $payout->status }}</span></div>
          <div class="detail-row"><b>Payment Transaction</b><span>{{ $payout->payment_transaction_id ?? '-' }}</span></div>
          <div class="detail-row"><b>Admin Remark</b><span>{{ $payout->admin_remark ?? '-' }}</span></div>
          <div class="detail-row"><b>Processed By</b><span>{{ $payout->processedBy->name ?? '-' }}</span></div>
        </div>
      </div>

      @if($payout->status === 'Pending')
      <form method="POST" action="{{ route('admin.payouts.update', $payout) }}" class="mt-4 border-top pt-4">
        @csrf
        @method('PATCH')
        <div class="row g-3">
          <div class="col-md-4"><label class="form-label">Decision</label><select name="status" class="form-select" required><option value="Approved">Approve as Paid</option><option value="Rejected">Reject and Refund Wallet</option></select></div>
          <div class="col-md-4"><label class="form-label">Payment Transaction ID</label><input type="text" name="payment_transaction_id" class="form-control" maxlength="100" placeholder="Required for approval"></div>
          <div class="col-md-4"><label class="form-label">Admin Remark</label><input type="text" name="admin_remark" class="form-control" maxlength="500" placeholder="Required for rejection"></div>
          <div class="col-12 text-end"><button class="btn btn-main px-4">Submit Decision</button></div>
        </div>
      </form>
      @endif
    </div>
  </div></div>
</div>
@endforeach
@endsection
