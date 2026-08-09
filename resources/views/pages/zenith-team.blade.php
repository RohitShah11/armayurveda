@extends('layouts.app')

@section('title', 'Zenith Team Package Commission')
@section('page-title', 'Zenith Team Package Commission')

@push('styles')
<style>
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.form-control,.form-select{height:48px;border-radius:12px}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.hero-box{background:linear-gradient(135deg,#06163b,#0d2d70);color:#fff;border-radius:20px;padding:30px;position:relative;overflow:hidden}
.hero-box:after{content:"";position:absolute;right:-70px;top:-70px;width:220px;height:220px;border:28px solid rgba(212,175,55,.35);border-radius:50%}
.hero-title{font-size:34px;font-weight:900;letter-spacing:1px}
.hero-title span{color:var(--gold)}
.level-card{background:#fff;border:1px solid #ead9a0;border-radius:14px;padding:14px;text-align:center;height:100%}
.level-no{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;background:var(--primary);color:#fff;font-weight:800;margin-bottom:8px}
.level-card h5{color:var(--primary);font-weight:900;margin:0}
.level-card p{margin:0;font-size:13px;color:#666}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
</style>
@endpush

@section('content')
@php
  $money = fn ($amount) => '&#8377;' . number_format((float) $amount, 2);
@endphp

<div class="hero-box mb-4">
  <div class="row align-items-center g-3">
    <div class="col-lg-8">
      <div class="hero-title">ZENITH <span>TEAM PACKAGE</span> COMMISSION</div>
      <p class="mb-0 mt-2">{{ $totalLevels }} level team income plan. Earn level-wise commission from your downline Zenith Package purchases.</p>
    </div>
    <div class="col-lg-4 text-lg-end">
      <div class="h6 mb-1">Total Plan Commission</div>
      <div class="display-5 fw-bold text-warning">{!! $money($planCommission) !!}</div>
      <small>Distributed across {{ $totalLevels }} configured levels</small>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Income</p><h3>{!! $money($totalIncome) !!}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month</p><h3>{!! $money($thisMonthIncome) !!}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Active Levels</p><h3>{{ $activeLevels }} / {{ $totalLevels }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Team Sales</p><h3>{{ number_format($totalTeamSales) }}</h3></div></div>
</div>

<div class="info-note mb-4">
  <b>Income Rule:</b> When a Zenith Package is purchased in your downline, the configured level commission is credited immediately to each eligible sponsor's earning wallet, up to {{ $totalLevels }} levels. The full configured distribution is {!! $money($planCommission) !!} per eligible package.
</div>

<div class="card-box mb-4">
  <h5 class="fw-bold mb-3">{{ $totalLevels }} Level Commission Structure</h5>
  <div class="row g-3">
    @forelse ($commissionStructure as $commission)
      <div class="col-lg-3 col-md-4 col-6">
        <div class="level-card">
          <span class="level-no">{{ $commission->level }}</span>
          <h5>{!! $money($commission->commission_amount) !!}</h5>
          <p>Level {{ $commission->level }}</p>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted py-3">No Zenith commission levels are configured.</div>
    @endforelse
  </div>
</div>

<div class="card-box mb-4">
  <h5 class="fw-bold mb-3">Search Team Commission</h5>
  <form method="GET" action="{{ route('income.zenith-team') }}">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">From Date</label>
        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">To Date</label>
        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Level</label>
        <select name="level" class="form-select">
          <option value="">All Levels</option>
          @foreach ($commissionStructure as $commission)
            <option value="{{ $commission->level }}" @selected((string) request('level') === (string) $commission->level)>Level {{ $commission->level }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
        <a href="{{ route('income.zenith-team') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="card-box">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Level Wise Team Package Commission List</h5>
    <small class="text-muted">Only commissions credited to {{ $user->member_id ?? 'your account' }}</small>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr><th>SL</th><th>Date</th><th>Package Buyer</th><th>Buyer ID</th><th>Level</th><th>Package Name</th><th>Commission</th><th>Remark</th></tr>
      </thead>
      <tbody>
        @forelse ($transactions as $transaction)
          @php
            $buyer = $transaction->sourceUser;
            $level = $transaction->commissionLevel();
          @endphp
          <tr>
            <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
            <td>{{ ($transaction->transaction_date ?? $transaction->created_at)?->format('d M Y') ?? '-' }}</td>
            <td>{{ $buyer?->name ?? 'Not recorded' }}</td>
            <td>{{ $buyer?->member_id ?? '-' }}</td>
            <td>{{ $level ? 'Level ' . $level : '-' }}</td>
            <td>{{ $transaction->commissionPackageName() }}</td>
            <td>{!! $money($transaction->amount) !!}</td>
            <td>{{ $transaction->description ?? 'Commission credited' }}</td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-4">No Zenith Team package commission records found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
    <small>Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} records</small>
    {{ $transactions->links() }}
  </div>
</div>
@endsection
