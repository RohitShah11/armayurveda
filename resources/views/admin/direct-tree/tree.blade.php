@extends('layouts.admin')

@section('title', 'Direct Tree')
@section('page-title', 'Direct Tree View')

@push('styles')
<style>
.tree-toolbar{display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap}
.tree-stage{background:#fff;border-radius:12px;padding:26px;box-shadow:0 8px 25px rgba(0,0,0,.07);overflow:auto}
.tree-canvas{min-width:980px;padding:10px 10px 30px}
.tree ul{padding-top:28px;position:relative;display:flex;justify-content:center;gap:18px;margin:0}
.tree li{list-style:none;text-align:center;position:relative;padding:28px 6px 0;flex:1;min-width:138px}
.tree li::before,.tree li::after{content:"";position:absolute;top:0;width:50%;height:28px;border-top:2px solid #c9d1dc}
.tree li::before{right:50%;border-right:2px solid #c9d1dc}
.tree li::after{left:50%;border-left:2px solid #c9d1dc}
.tree li:only-child::before,.tree li:only-child::after{display:none}
.tree li:first-child::before,.tree li:last-child::after{border:0}
.tree li:last-child::before{border-radius:0 8px 0 0}
.tree li:first-child::after{border-radius:8px 0 0 0}
.tree ul ul::before{content:"";position:absolute;top:0;left:50%;height:28px;border-left:2px solid #c9d1dc}
.direct-node-card{display:inline-flex;flex-direction:column;align-items:center;gap:7px;min-width:118px;max-width:142px;padding:10px 8px;border:1px solid #dbe3ef;border-radius:12px;background:#f8fbff;box-shadow:0 6px 14px rgba(15,23,42,.08);text-decoration:none;color:#1f2937}
.direct-node-card:hover{color:#1f2937;border-color:#1f2937;transform:translateY(-1px)}
.direct-node-card.admin{background:#fff7d6;border-color:#d4af37}
.node-icon{width:46px;height:46px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#0b5cab;color:#fff;font-weight:900;border:3px solid #d7e8ff}
.node-icon.admin{background:#d43d2f;border-color:#ffd8d4}
.node-name{font-size:13px;font-weight:800;line-height:1.2;max-width:120px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.node-meta{font-size:11px;color:#6b7280;max-width:120px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.tree-result{display:flex;justify-content:space-between;gap:14px;align-items:center;border-bottom:1px solid #eee;padding:10px 0}
.tree-result:last-child{border-bottom:0}
@media(max-width:991px){.tree-canvas{min-width:760px}.tree li{min-width:118px}.direct-node-card{min-width:108px}}
</style>
@endpush

@section('content')
<div class="tree-toolbar mb-4">
  <div>
    <h4 class="fw-bold mb-1">Direct Sponsor Tree</h4>
    <p class="text-muted mb-0">Admin root with sponsor based child branches.</p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.direct-tree.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
      <i class="fa fa-list me-1"></i> Listing View
    </a>
    <a href="{{ route('admin.direct-tree.tree') }}" class="btn btn-main rounded-pill px-4">
      <i class="fa fa-sitemap me-1"></i> Root Tree
    </a>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted fw-bold mb-1">Total Nodes</p><h3 class="fw-black mb-0">{{ number_format($totalNodes) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted fw-bold mb-1">Member Nodes</p><h3 class="fw-black mb-0">{{ number_format($memberNodes) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted fw-bold mb-1">Max Depth</p><h3 class="fw-black mb-0">{{ $maxDepth }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="admin-card"><p class="text-muted fw-bold mb-1">Focused Root</p><h3 class="fw-black mb-0">#{{ $rootNode?->id ?? '-' }}</h3></div></div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="admin-card h-100">
      <h5 class="fw-bold mb-3">Find Member In Tree</h5>
      <form method="GET" action="{{ route('admin.direct-tree.tree') }}" class="row g-3">
        <div class="col-12">
          <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name, member ID, mobile or node ID">
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
          <a href="{{ route('admin.direct-tree.tree') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
        </div>
      </form>

      @if(request('search'))
        <div class="mt-4">
          <h6 class="fw-bold">Search Results</h6>
          @forelse($searchNodes as $result)
            @php $owner = $result->user ?: $result->admin; @endphp
            <div class="tree-result">
              <div>
                <strong>#{{ $result->id }} - {{ $owner?->name ?? '-' }}</strong><br>
                <small class="text-muted">{{ $result->user?->member_id ?? $result->admin?->email ?? '-' }} | Depth {{ $result->depth }}</small>
              </div>
              <a href="{{ route('admin.direct-tree.tree', ['node' => $result->id]) }}" class="btn btn-sm btn-outline-dark">Focus</a>
            </div>
          @empty
            <p class="text-muted mb-0">No matching direct tree node found.</p>
          @endforelse
        </div>
      @endif
    </div>
  </div>
  <div class="col-lg-7">
    <div class="admin-card h-100">
      <h5 class="fw-bold mb-3">Legend</h5>
      <div class="row g-3">
        <div class="col-md-4"><span class="d-inline-block rounded-circle me-2" style="width:14px;height:14px;background:#d43d2f"></span>Admin Root</div>
        <div class="col-md-4"><span class="d-inline-block rounded-circle me-2" style="width:14px;height:14px;background:#0b5cab"></span>Member Node</div>
        <div class="col-md-4"><span class="d-inline-block rounded-circle me-2" style="width:14px;height:14px;background:#c9d1dc"></span>Sponsor Link</div>
      </div>
      <hr>
      <p class="text-muted mb-0">This page shows up to four levels under the focused node. Click any node to focus its branch.</p>
    </div>
  </div>
</div>

<div class="tree-stage">
  @if($tree)
    <div class="tree-canvas">
      <div class="tree">
        @include('admin.direct-tree.partials.tree-node', ['item' => $tree])
      </div>
    </div>
  @else
    <div class="text-center text-muted py-5">No direct tree root found yet.</div>
  @endif
</div>
@endsection
