@extends('layouts.admin')

@section('title', 'Zenith Pool')
@section('page-title', 'Zenith Pool Member View')

@push('styles')
<style>
.pool-stat{border-left:5px solid #1f2937}
.pool-stat p{margin-bottom:6px;color:#6b7280;font-weight:700}
.pool-stat h3{font-weight:900;margin-bottom:0}
.pool-node{display:flex;align-items:center;gap:10px}
.node-avatar{width:38px;height:38px;border-radius:50%;background:#1f2937;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:900}
.node-avatar.admin{background:#b8860b}
.tree-indent{display:inline-block;width:calc(var(--depth) * 18px)}
.progress{height:8px}
.badge-soft{background:#eef2ff;color:#3730a3}
.badge-paid{background:#dcfce7;color:#166534}
.badge-pending{background:#fef3c7;color:#92400e}
</style>
@endpush

@section('content')
@php
  $money = fn ($amount) => 'INR ' . number_format((float) $amount, 2);
  $levelSlots = [1 => 4, 2 => 16, 3 => 64, 4 => 256, 5 => 1024, 6 => 4096];
@endphp

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
  <div>
    <h4 class="fw-bold mb-1">Zenith Pool Listing</h4>
    <p class="text-muted mb-0">Placement records and completed pool payouts.</p>
  </div>
  <a href="{{ route('admin.zenith-pool.tree') }}" class="btn btn-main rounded-pill px-4">
    <i class="fa fa-sitemap me-1"></i> Tree View
  </a>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="admin-card pool-stat">
      <p>Total Pool Nodes</p>
      <h3>{{ number_format($totalNodes) }}</h3>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="admin-card pool-stat">
      <p>Zenith Members</p>
      <h3>{{ number_format($memberNodes) }}</h3>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="admin-card pool-stat">
      <p>Completed Level Payouts</p>
      <h3>{{ number_format($paidLevels) }}</h3>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="admin-card pool-stat">
      <p>Total Pool Paid</p>
      <h3>{{ $money($totalPaid) }}</h3>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="admin-card h-100">
      <h5 class="fw-bold mb-3"><i class="fa fa-crown me-2"></i>Root & Pool Summary</h5>
      <div class="detail-row"><span>Root</span><span>{{ $rootNode?->user?->name ?? 'Root user not created' }}</span></div>
      <div class="detail-row"><span>Root Income</span><span>{{ $money($rootIncome) }}</span></div>
      <div class="detail-row"><span>Max Filled Depth</span><span>{{ $maxDepth }}</span></div>
      <div class="detail-row"><span>Matrix Rule</span><span>4 direct slots, 6 payout levels</span></div>
      <div class="detail-row"><span>Payout Rule</span><span>Paid once when a level is complete</span></div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="admin-card h-100">
      <h5 class="fw-bold mb-3"><i class="fa fa-layer-group me-2"></i>Depth Fill Overview</h5>
      @forelse($depthStats as $stat)
        @php
          $capacity = $stat->depth == 0 ? 1 : 4 ** (int) $stat->depth;
          $percent = $capacity > 0 ? min(100, round(($stat->total / $capacity) * 100)) : 0;
        @endphp
        <div class="mb-3">
          <div class="d-flex justify-content-between small fw-bold mb-1">
            <span>{{ $stat->depth == 0 ? 'Admin Root' : 'Level ' . $stat->depth }}</span>
            <span>{{ $stat->total }} / {{ $capacity }}</span>
          </div>
          <div class="progress">
            <div class="progress-bar bg-dark" style="width: {{ $percent }}%"></div>
          </div>
        </div>
      @empty
        <p class="text-muted mb-0">No pool nodes found yet.</p>
      @endforelse
    </div>
  </div>
</div>

<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.zenith-pool.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-5">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pool ID, member ID, name, mobile or email">
      </div>
      <div class="col-md-2">
        <label class="form-label">Depth</label>
        <select name="depth" class="form-select">
          <option value="">All</option>
          @for($depth = 0; $depth <= max(6, $maxDepth); $depth++)
            <option value="{{ $depth }}" @selected((string) request('depth') === (string) $depth)>{{ $depth == 0 ? 'Root' : 'Level ' . $depth }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Income Status</label>
        <select name="status" class="form-select">
          <option value="">All</option>
          <option value="completed" @selected(request('status') === 'completed')>Has Payout</option>
          <option value="pending" @selected(request('status') === 'pending')>No Payout</option>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
        <a href="{{ route('admin.zenith-pool.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="admin-card mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Pool Member Placement</h5>
    <small class="text-muted">Showing {{ $nodes->firstItem() ?? 0 }} to {{ $nodes->lastItem() ?? 0 }} of {{ $nodes->total() }}</small>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Pool Node</th>
          <th>Member / Admin</th>
          <th>Parent</th>
          <th>Depth</th>
          <th>Position</th>
          <th>Children</th>
          <th>Package Purchase</th>
          <th>Completed Levels</th>
          <th>Joined</th>
        </tr>
      </thead>
      <tbody>
        @forelse($nodes as $node)
          @php
            $owner = $node->user;
            $parentOwner = $node->parent?->user;
            $isRoot = $node->parent_id === null;
            $completedLevels = $node->levelIncomes->pluck('level')->sort()->values();
          @endphp
          <tr>
            <td>
              <span class="tree-indent" style="--depth: {{ min($node->depth, 8) }}"></span>
              <strong>#{{ $node->id }}</strong>
            </td>
            <td>
              <div class="pool-node">
                <span class="node-avatar {{ $isRoot ? 'admin' : '' }}">{{ $isRoot ? 'A' : strtoupper(substr($owner?->name ?? 'M', 0, 1)) }}</span>
                <div>
                  <strong>{{ $owner?->name ?? '-' }}</strong><br>
                  <small class="text-muted">{{ $node->user?->member_id ?? $node->user?->email ?? '-' }}</small>
                </div>
              </div>
            </td>
            <td>
              {{ $parentOwner?->name ?? '-' }}<br>
              <small class="text-muted">{{ $node->parent?->user?->member_id ?? $node->parent?->user?->email ?? '-' }}</small>
            </td>
            <td><span class="badge badge-soft">{{ $node->depth == 0 ? 'Root' : 'Level ' . $node->depth }}</span></td>
            <td>{{ $node->parent_id ? $node->position . ' / 4' : '-' }}</td>
            <td>{{ $node->children_count }} / 4</td>
            <td>
              @if($node->packagePurchase)
                {{ $money($node->packagePurchase->package_price) }}<br>
                <small class="text-muted">{{ optional($node->packagePurchase->purchase_date)->format('d M Y') }}</small>
              @else
                -
              @endif
            </td>
            <td>
              @if($completedLevels->isNotEmpty())
                @foreach($completedLevels as $level)
                  <span class="badge badge-paid">L{{ $level }}</span>
                @endforeach
              @else
                <span class="badge badge-pending">Pending</span>
              @endif
            </td>
            <td>{{ optional($node->joined_at)->format('d M Y h:i A') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center text-muted py-4">No Zenith pool members found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $nodes->links() }}</div>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Recent Completed Pool Incomes</h5>
    <span class="badge bg-dark">Level completion payouts</span>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Receiver</th>
          <th>Level</th>
          <th>Slots</th>
          <th>Amount</th>
          <th>Paid At</th>
        </tr>
      </thead>
      <tbody>
        @forelse($levelIncomes as $income)
          @php $receiver = $income->node?->user; @endphp
          <tr>
            <td>{{ $income->id }}</td>
            <td>
              <strong>{{ $receiver?->name ?? '-' }}</strong><br>
              <small class="text-muted">{{ $income->node?->user?->member_id ?? $income->node?->user?->email ?? '-' }}</small>
            </td>
            <td>Level {{ $income->level }}</td>
            <td>{{ $income->slots_required }} / {{ $income->slots_required }}</td>
            <td>{{ $money($income->amount) }}</td>
            <td>{{ optional($income->paid_at)->format('d M Y h:i A') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">No completed pool incomes yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
