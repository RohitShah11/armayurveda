@extends('layouts.app')

@section('title', 'Zenith Non-Working Global Pool Income')
@section('page-title', 'Zenith Non-Working Global Pool Income')

@push('styles')
<style>
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:48px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.global-box{background:linear-gradient(135deg,#07183f,#0c2d6b);color:#fff;border-radius:18px;padding:25px;height:100%;position:relative;overflow:hidden}
.global-box:after{content:"";position:absolute;right:-40px;top:-40px;width:150px;height:150px;border-radius:50%;background:rgba(212,175,55,.18)}
.global-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.global-row span:last-child{font-weight:700;text-align:right;color:#ffe799}
.level-card{border:1px solid #f1e1a6;border-radius:16px;overflow:hidden}
.level-card .level-head{background:linear-gradient(135deg,var(--gold),#f9df7a);color:#111;font-weight:900;padding:12px 18px;text-align:center}
.level-line{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-bottom:1px solid #eee;gap:16px}
.level-badge{width:34px;height:34px;border-radius:50%;background:var(--blue);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:900;flex:0 0 34px}
.level-line b{font-size:18px;color:var(--primary)}
.formula-card{background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:18px;color:#fff;overflow:hidden}
.formula-card .step{padding:20px;border-right:1px solid rgba(255,255,255,.15)}
.formula-card small{color:#ffdce8}
.formula-card h5{font-weight:900;color:#ffe799;margin:5px 0 0}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-paid{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-process{background:#e8f0ff;color:#0d6efd}
.search-label{font-size:13px;font-weight:700;color:#555}
@media(max-width:576px){.global-row{display:block}.global-row span:last-child{text-align:left;display:block;margin-top:5px}.formula-card .step{border-right:0;border-bottom:1px solid rgba(255,255,255,.15)}}
</style>
@endpush

@section('content')
@php
  $money = fn ($amount) => '&#8377;' . number_format((float) $amount, 2);
  $currentLevel = $unlockedLevels > 0 ? 'Level ' . $unlockedLevels : 'Not Started';
  $nextLevelLabel = $nextLevel ? 'Level ' . $nextLevel : 'All Levels Complete';
@endphp

<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="card-box stat-card">
      <p>Total Global Pool Income</p>
      <h3>{!! $money($totalIncome) !!}</h3>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="card-box stat-card">
      <p>Unlocked Levels</p>
      <h3>{{ $unlockedLevels }} / 6</h3>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="card-box stat-card">
      <p>This Month Income</p>
      <h3 class="text-success">{!! $money($thisMonthIncome) !!}</h3>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="card-box stat-card">
      <p>Pool Status</p>
      <h3 class="{{ $node ? 'text-success' : 'text-warning' }}">{{ $node ? 'Active' : 'Inactive' }}</h3>
    </div>
  </div>
</div>

<div class="info-note mb-4">
  <b>Income Rule:</b> After purchasing the Zenith Package, members enter the 4 &times; 4 non-working global pool. Income is credited once per level only after that full matrix level is complete.
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="global-box">
      <h4 class="fw-bold mb-3"><i class="fa fa-globe"></i> Global Pool Overview</h4>
      <div class="global-row"><span>Income Name</span><span>Zenith Non-Working Global Pool Income</span></div>
      <div class="global-row"><span>Package Required</span><span>Zenith Package</span></div>
      <div class="global-row"><span>Matrix Type</span><span>4 &times; 4 Global Matrix</span></div>
      <div class="global-row"><span>Total Levels</span><span>6 Levels</span></div>
      <div class="global-row"><span>Working Required</span><span>No</span></div>
      <div class="global-row"><span>Your Pool Position</span><span>{{ $node ? '#' . $node->id : 'Not Joined' }}</span></div>
      <div class="global-row"><span>Your Current Level</span><span>{{ $currentLevel }}</span></div>
      <div class="global-row"><span>Next Level Target</span><span>{{ $nextLevelLabel }}</span></div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="level-card bg-white h-100 shadow-sm">
      <div class="level-head"><i class="fa fa-layer-group"></i> 6 Level Income Structure</div>
      @foreach ($levelRows as $row)
        <div class="level-line">
          <span class="d-flex align-items-center gap-2">
            <span class="level-badge">{{ $row['level'] }}</span>
            Level {{ $row['level'] }} Income
            <small class="text-muted">({{ $row['filled_slots'] }} / {{ $row['slots_required'] }})</small>
          </span>
          <b>{!! $money($row['amount']) !!}</b>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="formula-card mb-4">
  <div class="row g-0">
    <div class="col-lg-3 col-md-6 step"><small>Entry</small><h5>Buy Zenith Package</h5></div>
    <div class="col-lg-3 col-md-6 step"><small>System</small><h5>4 &times; 4 Matrix</h5></div>
    <div class="col-lg-3 col-md-6 step"><small>Benefit</small><h5>Completion Income</h5></div>
    <div class="col-lg-3 col-md-6 step"><small>Maximum</small><h5>&#8377;31,500 Total</h5></div>
  </div>
</div>

<div class="card-box mb-4">
  <h5 class="fw-bold mb-3">Search Global Pool Income</h5>
  <form method="GET" action="{{ route('income.non-working-pool') }}">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="search-label">From Date</label>
        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
      </div>
      <div class="col-md-3">
        <label class="search-label">To Date</label>
        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
      </div>
      <div class="col-md-3">
        <label class="search-label">Level</label>
        <select name="level" class="form-select">
          <option value="">All Levels</option>
          @for ($level = 1; $level <= 6; $level++)
            <option value="{{ $level }}" @selected((string) request('level') === (string) $level)>Level {{ $level }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3">
        <label class="search-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All Status</option>
          <option value="Paid" @selected(request('status') === 'Paid')>Paid</option>
          <option value="Pending" @selected(request('status') === 'Pending')>Pending</option>
        </select>
      </div>
      <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
        <a href="{{ route('income.non-working-pool') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="card-box">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Zenith Non-Working Global Pool Income List</h5>
    <span class="badge badge-process px-3 py-2">6 Levels of 4 Matrix Income</span>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>SL</th>
          <th>Date</th>
          <th>Member ID</th>
          <th>Member Name</th>
          <th>Package</th>
          <th>Matrix Level</th>
          <th>Matrix Position</th>
          <th>Income</th>
          <th>TDS / Charge</th>
          <th>Net Income</th>
          <th>Status</th>
          <th>Credit Date</th>
          <th>Remark</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($filteredLevelRows as $index => $row)
          @php
            $income = $row['income'];
            $paidAt = $income?->paid_at;
          @endphp
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $paidAt ? $paidAt->format('d M Y') : '-' }}</td>
            <td>{{ $user?->member_id ?? '-' }}</td>
            <td>{{ $user?->name ?? '-' }}</td>
            <td>Zenith</td>
            <td>Level {{ $row['level'] }}</td>
            <td>{{ $row['filled_slots'] }} / {{ $row['slots_required'] }}</td>
            <td>{!! $money($row['amount']) !!}</td>
            <td>&#8377;0.00</td>
            <td>{!! $money($row['amount']) !!}</td>
            <td>
              <span class="badge {{ $income ? 'badge-paid' : 'badge-pending' }}">
                {{ $income ? 'Paid' : 'Pending' }}
              </span>
            </td>
            <td>{{ $paidAt ? $paidAt->format('d M Y') : '-' }}</td>
            <td>{{ $income ? 'Level ' . $row['level'] . ' completed' : 'Waiting for matrix completion' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="13" class="text-center text-muted py-4">No pool income records found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
