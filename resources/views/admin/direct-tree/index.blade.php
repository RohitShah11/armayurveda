@extends('layouts.admin')

@section('title', 'Direct Tree')
@section('page-title', 'Direct Tree Member View')

@push('styles')
<style>
.tree-stat{border-left:5px solid #1f2937}
.tree-stat p{margin-bottom:6px;color:#6b7280;font-weight:700}
.tree-stat h3{font-weight:900;margin-bottom:0}
.tree-member{display:flex;align-items:center;gap:10px}
.node-avatar{width:38px;height:38px;border-radius:50%;background:#1f2937;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:900}
.node-avatar.admin{background:#b8860b}
.tree-indent{display:inline-block;width:calc(var(--depth) * 18px)}
.badge-soft{background:#eef2ff;color:#3730a3}
</style>
@endpush

@section('content')
@php $money = fn ($amount) => 'INR ' . number_format((float) $amount, 2); @endphp

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
  <div>
    <h4 class="fw-bold mb-1">Direct Tree Listing</h4>
    <p class="text-muted mb-0">Sponsor based genealogy created on first package purchase.</p>
  </div>
  <a href="{{ route('admin.direct-tree.tree') }}" class="btn btn-main rounded-pill px-4">
    <i class="fa fa-sitemap me-1"></i> Tree View
  </a>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="admin-card tree-stat"><p>Total Nodes</p><h3>{{ number_format($totalNodes) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card tree-stat"><p>Member Nodes</p><h3>{{ number_format($memberNodes) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card tree-stat"><p>Max Depth</p><h3>{{ $maxDepth }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card tree-stat"><p>Root</p><h3>{{ $rootNode?->user?->name ?? 'Admin' }}</h3></div></div>
</div>

<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.direct-tree.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Node ID, member ID, name, mobile or email">
      </div>
      <div class="col-md-3">
        <label class="form-label">Depth</label>
        <select name="depth" class="form-select">
          <option value="">All</option>
          @for($depth = 0; $depth <= max(6, $maxDepth); $depth++)
            <option value="{{ $depth }}" @selected((string) request('depth') === (string) $depth)>{{ $depth == 0 ? 'Root' : 'Level ' . $depth }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
        <a href="{{ route('admin.direct-tree.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="admin-card h-100">
      <h5 class="fw-bold mb-3"><i class="fa fa-crown me-2"></i>Root & Rule</h5>
      <div class="detail-row"><span>Root</span><span>{{ $rootNode?->user?->name ?? 'Root user not created' }}</span></div>
      <div class="detail-row"><span>Placement Rule</span><span>Buyer placed under direct sponsor</span></div>
      <div class="detail-row"><span>Fallback Parent</span><span>Admin root</span></div>
      <div class="detail-row"><span>Children Limit</span><span>Unlimited directs</span></div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="admin-card h-100">
      <h5 class="fw-bold mb-3"><i class="fa fa-layer-group me-2"></i>Depth Overview</h5>
      @forelse($depthStats as $stat)
        <div class="d-flex justify-content-between border-bottom py-2">
          <strong>{{ $stat->depth == 0 ? 'Admin Root' : 'Level ' . $stat->depth }}</strong>
          <span>{{ number_format($stat->total) }} nodes</span>
        </div>
      @empty
        <p class="text-muted mb-0">No direct tree nodes found yet.</p>
      @endforelse
    </div>
  </div>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">Direct Tree Placement</h5>
    <small class="text-muted">Showing {{ $nodes->firstItem() ?? 0 }} to {{ $nodes->lastItem() ?? 0 }} of {{ $nodes->total() }}</small>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Node</th>
          <th>Member / Admin</th>
          <th>Parent</th>
          <th>Depth</th>
          <th>Direct Position</th>
          <th>Directs</th>
          <th>Current Rank</th>
          <th>Package Purchase</th>
          <th>Joined</th>
        </tr>
      </thead>
      <tbody>
        @forelse($nodes as $node)
          @php
            $owner = $node->user;
            $parentOwner = $node->parent?->user;
            $isRoot = $node->parent_id === null;
            $currentRank = $node->user?->rankRewards?->sortByDesc('rank')->first();
          @endphp
          <tr>
            <td><span class="tree-indent" style="--depth: {{ min($node->depth, 8) }}"></span><strong>#{{ $node->id }}</strong></td>
            <td>
              <div class="tree-member">
                <span class="node-avatar {{ $isRoot ? 'admin' : '' }}">{{ $isRoot ? 'A' : strtoupper(substr($owner?->name ?? 'M', 0, 1)) }}</span>
                <div>
                  <strong>{{ $owner?->name ?? '-' }}</strong><br>
                  <small class="text-muted">{{ $node->user?->member_id ?? $node->user?->email ?? '-' }}</small>
                </div>
              </div>
            </td>
            <td>{{ $parentOwner?->name ?? '-' }}<br><small class="text-muted">{{ $node->parent?->user?->member_id ?? $node->parent?->user?->email ?? '-' }}</small></td>
            <td><span class="badge badge-soft">{{ $node->depth == 0 ? 'Root' : 'Level ' . $node->depth }}</span></td>
            <td>{{ $node->parent_id ? $node->position : '-' }}</td>
            <td>{{ $node->children_count }}</td>
            <td>
              @if($currentRank)
                <span class="badge bg-success">Rank {{ $currentRank->rank }}</span><br>
                <small>{{ $currentRank->rank_name }}</small>
              @else
                -
              @endif
            </td>
            <td>
              @if($node->packagePurchase)
                {{ $money($node->packagePurchase->package_price) }}<br>
                <small class="text-muted">{{ optional($node->packagePurchase->purchase_date)->format('d M Y') }}</small>
              @else
                -
              @endif
            </td>
            <td>{{ optional($node->joined_at)->format('d M Y h:i A') ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center text-muted py-4">No direct tree members found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $nodes->links() }}</div>
</div>
@endsection
