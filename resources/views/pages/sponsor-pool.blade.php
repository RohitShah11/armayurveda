@extends('layouts.app')

@section('title', 'Sponsor Global Pool Income')
@section('page-title', 'Sponsor Global Pool Income')

@push('styles')
<style>
.pool-card{background:#fff;border-radius:16px;padding:22px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.pool-stat{border-left:5px solid var(--primary)}.pool-stat p{margin-bottom:6px;color:#6b7280;font-weight:700}.pool-stat h3{font-weight:900;color:var(--primary);margin:0}
.plan-box{background:linear-gradient(135deg,#061837,#0b2d64);color:#fff;border-radius:16px;padding:22px;height:100%}.plan-title{font-weight:900;color:#ffe799}
.level-card{background:#fff;border:1px solid #ead28a;border-radius:12px;padding:11px 13px;display:flex;justify-content:space-between;margin-bottom:9px;color:#071b3d}.level-card b:last-child{color:#b00020}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:12px;padding:16px}.table thead th{background:var(--primary);color:#fff;white-space:nowrap}.table td{vertical-align:middle}
.progress{height:8px}.badge-paid{background:#dcfce7;color:#166534}.badge-progress{background:#fef3c7;color:#92400e}.entry-id{font-weight:900;color:var(--primary)}
</style>
@endpush

@section('content')
@php
  $money = function ($amount) {
      return 'INR '.number_format((float) $amount, 2);
  };
@endphp

<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="pool-card pool-stat"><p>Total Pool Income</p><h3>{{ $money($totalPoolIncome) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="pool-card pool-stat"><p>Pool Entries</p><h3>{{ number_format($totalEntries) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="pool-card pool-stat"><p>Completed Payouts</p><h3 class="text-success">{{ number_format($completedPayouts) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="pool-card pool-stat"><p>Active Entries</p><h3 class="text-warning">{{ number_format($activeEntries) }}</h3></div></div>
</div>

<div class="info-note mb-4"><b>Income rule:</b> Each direct referral who purchases the Zenith Package creates one Sponsor Pool entry for you. Income is credited automatically when a pool level is completely filled.</div>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="plan-box">
      <h4 class="plan-title mb-3"><i class="fa fa-users-rays me-2"></i>6-Level Pool Plan</h4>
      @foreach($incomePlan as $plan)
        <div class="level-card"><span><b>Level {{ $plan['level'] }}</b> <small>({{ number_format($plan['slots_required']) }} slots)</small></span><b>{{ $money($plan['amount']) }}</b></div>
      @endforeach
    </div>
  </div>
  <div class="col-lg-7">
    <div class="pool-card h-100">
      <h5 class="fw-bold mb-3">Filter Pool Records</h5>
      <form method="GET" action="{{ route('income.sponsor-pool') }}" class="row g-3">
        <div class="col-md-4"><label class="form-label">From Date</label><input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">To Date</label><input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Income Level</label><select name="level" class="form-select"><option value="">All Levels</option>@foreach($incomePlan as $plan)<option value="{{ $plan['level'] }}" @selected((string) request('level') === (string) $plan['level'])>Level {{ $plan['level'] }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Entry Status</label><select name="status" class="form-select"><option value="">All Entries</option><option value="paid" @selected(request('status') === 'paid')>Has Payout</option><option value="progress" @selected(request('status') === 'progress')>In Progress</option></select></div>
        <div class="col-md-8"><label class="form-label">Member or Entry ID</label><input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, member ID or pool entry ID"></div>
        <div class="col-12 d-flex gap-2"><button class="btn btn-main"><i class="fa fa-search me-1"></i>Search</button><a href="{{ route('income.sponsor-pool') }}" class="btn btn-secondary rounded-pill px-4">Reset</a></div>
      </form>
    </div>
  </div>
</div>

<div class="pool-card mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h5 class="fw-bold mb-0">My Pool Entries</h5><small class="text-muted">{{ $entries->total() }} entries</small></div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Entry</th><th>Direct Member</th><th>Package</th><th>Current Progress</th><th>Completed Levels</th><th>Entry Date</th></tr></thead>
      <tbody>
        @forelse($entries as $entry)
          @php
            $progress = collect($entryProgress->get($entry->id, []));
            $current = $progress->first(fn ($level) => ! $level['paid']) ?? $progress->last();
            $completed = $progress->where('paid', true)->pluck('level');
          @endphp
          <tr>
            <td><span class="entry-id">SP-{{ $entry->id }}</span></td>
            <td><strong>{{ $entry->purchaser?->name ?? '-' }}</strong><br><small class="text-muted">{{ $entry->purchaser?->member_id ?? '-' }}</small></td>
            <td>{{ $entry->packagePurchase?->package_name ?? '-' }}<br><small class="text-muted">{{ $money($entry->packagePurchase?->package_price ?? 0) }}</small></td>
            <td style="min-width:190px">
              @if($current)
                <div class="d-flex justify-content-between small mb-1"><span>Level {{ $current['level'] }}</span><span>{{ $current['filled_slots'] }}/{{ $current['slots_required'] }}</span></div>
                <div class="progress"><div class="progress-bar bg-warning" style="width:{{ $current['percentage'] }}%"></div></div>
              @else - @endif
            </td>
            <td>@forelse($completed as $level)<span class="badge badge-paid">L{{ $level }} Paid</span> @empty<span class="badge badge-progress">In Progress</span>@endforelse</td>
            <td>{{ optional($entry->joined_at)->format('d M Y h:i A') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">No Sponsor Pool entries found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $entries->links() }}</div>
</div>

<div class="pool-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h5 class="fw-bold mb-0">Pool Income History</h5><small class="text-muted">{{ $incomes->total() }} payouts</small></div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead><tr><th>Date</th><th>Entry</th><th>Direct Member</th><th>Level</th><th>Slots Completed</th><th>Income</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($incomes as $income)
          <tr>
            <td>{{ optional($income->paid_at)->format('d M Y h:i A') ?? '-' }}</td>
            <td><span class="entry-id">SP-{{ $income->sponsor_pool_node_id }}</span></td>
            <td>{{ $income->node?->purchaser?->name ?? '-' }}<br><small class="text-muted">{{ $income->node?->purchaser?->member_id ?? '-' }}</small></td>
            <td><span class="badge bg-dark">Level {{ $income->level }}</span></td>
            <td>{{ number_format($income->slots_required) }}</td>
            <td class="fw-bold text-success">{{ $money($income->amount) }}</td>
            <td><span class="badge badge-paid">Paid</span></td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted py-4">No Sponsor Pool income has been credited yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $incomes->links() }}</div>
</div>
@endsection
