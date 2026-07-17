@extends('layouts.app')

@section('title', 'Rank & Reward')
@section('page-title', 'Rank & Reward')

@push('styles')
<style>
.rank-stat{border-left:5px solid #0f5132}
.rank-stat p{margin-bottom:6px;color:#6b7280;font-weight:700}
.rank-stat h3{font-weight:900;margin-bottom:0}
.rank-current{background:#0f5132;color:#fff;border-radius:12px;padding:24px}
.rank-current small{color:rgba(255,255,255,.75)}
.rank-table thead th{white-space:nowrap}
</style>
@endpush

@section('content')
@php
  $money = fn ($amount) => '₹' . number_format((float) $amount, 2);
  $currentRank = $progress['current_rank'];
  $nextRank = $progress['next_rank'];
@endphp

<div class="row g-4 mb-4">
  <div class="col-lg-4">
    <div class="rank-current h-100">
      <small>Current Rank</small>
      <h3 class="fw-bold mt-2 mb-1">{{ $currentRank?->rank_name ?? 'No Rank Yet' }}</h3>
      <p class="mb-0">{{ $currentRank ? 'Rank '.$currentRank->rank.' achieved' : 'Build team package business to unlock rewards.' }}</p>
    </div>
  </div>
  <div class="col-lg-4 col-md-6"><div class="card-box rank-stat h-100"><p>Team Business</p><h3>{{ $money($progress['business']) }}</h3></div></div>
  <div class="col-lg-4 col-md-6"><div class="card-box rank-stat h-100"><p>Next Target</p><h3>{{ $nextRank ? $money($nextRank['business']) : 'Completed' }}</h3></div></div>
</div>

<div class="card-box mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div>
      <h5 class="fw-bold mb-1">Rank Progress</h5>
      <small class="text-muted">Basic + Zenith team package business up to 15 direct-tree levels.</small>
    </div>
    <span class="badge bg-success">{{ $nextRank ? $money($progress['remaining']).' remaining' : 'All ranks achieved' }}</span>
  </div>

  @if($nextRank)
    @php $percent = $nextRank['business'] > 0 ? min(100, ($progress['business'] / $nextRank['business']) * 100) : 100; @endphp
    <div class="progress" style="height:14px">
      <div class="progress-bar bg-success" style="width: {{ $percent }}%"></div>
    </div>
    <div class="d-flex justify-content-between mt-2">
      <strong>{{ $money($progress['business']) }}</strong>
      <span>{{ $nextRank['name'] }}</span>
    </div>
  @else
    <p class="mb-0 text-muted">You have achieved the highest configured rank.</p>
  @endif
</div>

<div class="card-box mb-4">
  <h5 class="fw-bold mb-3">Achieved Rewards</h5>
  <div class="table-responsive">
    <table class="table table-bordered align-middle rank-table">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Rank Name</th>
          <th>Qualified Business</th>
          <th>Reward</th>
          <th>Additional Reward</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rankRewards as $reward)
          <tr>
            <td>{{ $reward->rank }}</td>
            <td><strong>{{ $reward->rank_name }}</strong></td>
            <td>{{ $money($reward->qualified_business) }}</td>
            <td>{{ $money($reward->reward_amount) }}</td>
            <td>{{ $reward->additional_reward ?? '-' }}</td>
            <td>{{ optional($reward->qualified_at)->format('d M Y h:i A') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">No rank reward achieved yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="card-box">
  <h5 class="fw-bold mb-3">Rank Plan</h5>
  <div class="table-responsive">
    <table class="table table-bordered align-middle rank-table">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Name</th>
          <th>Required Business</th>
          <th>One-Time Reward</th>
          <th>Additional Reward</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rankPlan as $rank => $config)
          <tr>
            <td>{{ $rank }}</td>
            <td><strong>{{ $config['name'] }}</strong></td>
            <td>{{ $money($config['business']) }}</td>
            <td>{{ $money($config['reward']) }}</td>
            <td>{{ $config['additional'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
