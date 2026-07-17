@extends('layouts.admin')

@section('title', 'Rank & Reward')
@section('page-title', 'Rank & Reward')

@push('styles')
<style>
.rank-stat{border-left:5px solid #1f2937}
.rank-stat p{margin-bottom:6px;color:#6b7280;font-weight:700}
.rank-stat h3{font-weight:900;margin-bottom:0}
.rank-plan-card{border:1px solid #e5e7eb;border-radius:10px;padding:14px;height:100%}
.rank-plan-card strong{color:#1f2937}
</style>
@endpush

@section('content')
@php $money = fn ($amount) => 'INR ' . number_format((float) $amount, 2); @endphp

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
  <div>
    <h4 class="fw-bold mb-1">Rank & Reward Report</h4>
    <p class="text-muted mb-0">One-time rank payouts from Basic + Zenith team business up to 15 direct-tree levels.</p>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-4 col-md-6"><div class="admin-card rank-stat"><p>Total Rewards</p><h3>{{ number_format($totalRewards) }}</h3></div></div>
  <div class="col-lg-4 col-md-6"><div class="admin-card rank-stat"><p>Total Paid</p><h3>{{ $money($totalPaid) }}</h3></div></div>
  <div class="col-lg-4 col-md-6"><div class="admin-card rank-stat"><p>Highest Rank Paid</p><h3>{{ $highestRank ?: '-' }}</h3></div></div>
</div>

<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.rank-rewards.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-lg-4">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Member, rank, mobile or email">
      </div>
      <div class="col-lg-2 col-md-4">
        <label class="form-label">Rank</label>
        <select name="rank" class="form-select">
          <option value="">All</option>
          @foreach($rankPlan as $rank => $config)
            <option value="{{ $rank }}" @selected((string) request('rank') === (string) $rank)>Rank {{ $rank }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-lg-2 col-md-4">
        <label class="form-label">From</label>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
      </div>
      <div class="col-lg-2 col-md-4">
        <label class="form-label">To</label>
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
      </div>
      <div class="col-lg-2 d-flex gap-2">
        <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
        <a href="{{ route('admin.rank-rewards.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="admin-card mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Reward Payouts</h5>
    <small class="text-muted">Showing {{ $latestRewards->firstItem() ?? 0 }} to {{ $latestRewards->lastItem() ?? 0 }} of {{ $latestRewards->total() }}</small>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Member</th>
          <th>Rank</th>
          <th>Qualified Business</th>
          <th>Reward</th>
          <th>Additional</th>
          <th>Status</th>
          <th>Qualified</th>
        </tr>
      </thead>
      <tbody>
        @forelse($latestRewards as $reward)
          <tr>
            <td>
              <strong>{{ $reward->user?->name ?? '-' }}</strong><br>
              <small class="text-muted">{{ $reward->user?->member_id ?? '-' }} | {{ $reward->user?->mobile ?? '-' }}</small>
            </td>
            <td>Rank {{ $reward->rank }}<br><strong>{{ $reward->rank_name }}</strong></td>
            <td>{{ $money($reward->qualified_business) }}</td>
            <td>{{ $money($reward->reward_amount) }}</td>
            <td>{{ $reward->additional_reward ?? '-' }}</td>
            <td><span class="badge bg-success">{{ $reward->status }}</span></td>
            <td>{{ optional($reward->qualified_at)->format('d M Y h:i A') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted py-4">No rank rewards paid yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $latestRewards->links() }}</div>
</div>

<div class="admin-card">
  <h5 class="fw-bold mb-3">Rank Plan</h5>
  <div class="row g-3">
    @foreach($rankPlan as $rank => $config)
      <div class="col-lg-4 col-md-6">
        <div class="rank-plan-card">
          <div class="d-flex justify-content-between gap-2">
            <strong>Rank {{ $rank }}</strong>
            <span>{{ $money($config['reward']) }}</span>
          </div>
          <div class="mt-2">{{ $config['name'] }}</div>
          <small class="text-muted">{{ $money($config['business']) }} business | {{ $config['additional'] }}</small>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
