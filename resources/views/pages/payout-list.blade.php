@extends('layouts.app')

@section('title', 'Payout List')
@section('page-title', 'Payout List')

@push('styles')
<style>
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{min-height:48px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Requests</p><h3>{{ number_format($totalRequests) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending</p><h3 class="text-warning">₹{{ number_format($pendingAmount, 2) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Approved</p><h3 class="text-success">₹{{ number_format($approvedAmount, 2) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Rejected / Refunded</p><h3 class="text-danger">₹{{ number_format($rejectedAmount, 2) }}</h3></div></div>
</div>

<div class="card-box mb-4">
  <form method="GET" action="{{ route('payout.list') }}">
    <div class="row g-3 align-items-end">
      <div class="col-lg-2 col-md-6"><label class="form-label">From Date</label><input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control"></div>
      <div class="col-lg-2 col-md-6"><label class="form-label">To Date</label><input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control"></div>
      <div class="col-lg-2 col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All Statuses</option>
          @foreach(['Pending', 'Approved', 'Rejected'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach
        </select>
      </div>
      <div class="col-lg-3 col-md-6"><label class="form-label">Search</label><input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Request / transaction ID"></div>
      <div class="col-lg-3 d-flex gap-2"><button class="btn btn-main flex-fill"><i class="fa fa-search"></i> Search</button><a href="{{ route('payout.list') }}" class="btn btn-secondary rounded-pill px-4">Reset</a></div>
    </div>
  </form>
</div>

<div class="card-box">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div><h5 class="fw-bold mb-0">Previous Payout Requests</h5><small class="text-muted">The wallet amount is refunded automatically when a request is rejected.</small></div>
    <a href="{{ route('payout.request') }}" class="btn btn-main btn-sm"><i class="fa fa-plus"></i> New Request</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Request</th><th>Request Date</th><th>Amount</th><th>Net Payable</th><th>Mode</th><th>Status</th><th>Processed Date</th><th>Transaction ID</th><th>Admin Remark</th></tr></thead>
      <tbody>
        @forelse($payouts as $payout)
          @php($badge = match($payout->status) {'Approved' => 'success', 'Rejected' => 'danger', default => 'warning'})
          <tr>
            <td><strong>{{ $payout->request_no }}</strong></td>
            <td>{{ $payout->created_at?->format('d M Y, h:i A') }}</td>
            <td>₹{{ number_format((float) $payout->amount, 2) }}</td>
            <td>₹{{ number_format((float) $payout->net_amount, 2) }}</td>
            <td>{{ $payout->mode }}@if($payout->mode === 'UPI')<br><small class="text-muted">{{ $payout->upi_id }}</small>@endif</td>
            <td><span class="badge bg-{{ $badge }}">{{ $payout->status }}</span>@if($payout->refunded_at)<br><small class="text-success">Wallet refunded</small>@endif</td>
            <td>{{ $payout->processed_at?->format('d M Y, h:i A') ?? '-' }}</td>
            <td>{{ $payout->payment_transaction_id ?? '-' }}</td>
            <td>{{ $payout->admin_remark ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center py-5 text-muted">No payout requests found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $payouts->links() }}</div>
</div>
@endsection
