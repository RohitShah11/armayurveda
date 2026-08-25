@extends('layouts.app')

@section('title', 'Level Wise Team Member')
@section('page-title', 'Level Wise Team Member')

@push('styles')
<style>
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:46px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.btn-main:hover{background:var(--dark);color:#fff}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.member-img{width:42px;height:42px;border-radius:50%;object-fit:cover}
.badge-zenith{background:#dff7e8;color:#198754}.badge-inactive{background:#fde2e2;color:#dc3545}
.progress{height:9px;border-radius:20px}.level-card{border-left:5px solid var(--gold)}
</style>
@endpush

@section('content')
@php($percentage = fn (int $value) => $totals['members'] > 0 ? round(($value / $totals['members']) * 100, 1) : 0)

<div class="row g-4 mb-4">
  <div class="col-lg-4 col-md-6"><div class="card-box stat-card"><p>Total {{ $maxLevels }} Level Members</p><h3>{{ number_format($totals['members']) }}</h3></div></div>
  <div class="col-lg-4 col-md-6"><div class="card-box stat-card"><p>Zenith Package</p><h3 class="text-success">{{ number_format($totals['zenith']) }}</h3></div></div>
  <div class="col-lg-4 col-md-6"><div class="card-box stat-card"><p>Not Purchased</p><h3 class="text-danger">{{ number_format($totals['inactive']) }}</h3></div></div>
</div>

<div class="card-box mb-4">
  <div class="mb-3"><h5 class="fw-bold mb-1">{{ $maxLevels }} Level Member Count</h5><p class="text-muted mb-0">Level-wise package status from your sponsor team.</p></div>
  <div class="table-responsive"><table class="table table-bordered align-middle">
    <thead><tr><th>Level</th><th>Total Members</th><th>Zenith Package</th><th>Not Purchased</th><th>Active %</th><th>View Members</th></tr></thead>
    <tbody>@foreach($levelSummary as $level => $summary)<tr><td>Level {{ $level }}</td><td>{{ $summary['total'] }}</td><td>{{ $summary['zenith'] }}</td><td>{{ $summary['inactive'] }}</td><td>{{ number_format($summary['active_percentage'], 1) }}%</td><td><a href="{{ route('team.level', ['level' => $level]) }}" class="btn btn-sm btn-outline-primary">View</a></td></tr>@endforeach</tbody>
    <tfoot><tr class="fw-bold"><td>Total</td><td>{{ $totals['members'] }}</td><td>{{ $totals['zenith'] }}</td><td>{{ $totals['inactive'] }}</td><td colspan="2">{{ $maxLevels }} Level Total</td></tr></tfoot>
  </table></div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-6"><div class="card-box level-card h-100"><h5 class="fw-bold mb-3">Package Distribution</h5>
    @foreach(['zenith' => ['Zenith Package', 'success'], 'inactive' => ['Not Purchased', 'danger']] as $key => [$label, $color])
      @php($value = $percentage($totals[$key]))
      <p class="mb-1">{{ $label }} <span class="float-end">{{ number_format($value, 1) }}%</span></p><div class="progress mb-3"><div class="progress-bar bg-{{ $color }}" style="width:{{ $value }}%"></div></div>
    @endforeach
  </div></div>
  <div class="col-lg-6"><div class="card-box level-card h-100"><h5 class="fw-bold mb-3">Quick Level Overview</h5><div class="row g-3">
    <div class="col-6"><p class="mb-1">Highest Team Level</p><h4 class="fw-bold text-primary">{{ $highestLevel ? 'Level '.$highestLevel : '-' }}</h4></div>
    <div class="col-6"><p class="mb-1">Largest Level</p><h4 class="fw-bold text-success">{{ $largestLevel ? 'Level '.$largestLevel : '-' }}</h4></div>
    <div class="col-6"><p class="mb-1">Smallest Level</p><h4 class="fw-bold text-danger">{{ $smallestLevel ? 'Level '.$smallestLevel : '-' }}</h4></div>
    <div class="col-6"><p class="mb-1">Active Package Members</p><h4 class="fw-bold text-warning">{{ $totals['active'] }}</h4></div>
  </div></div></div>
</div>

<div class="card-box mb-4"><h5 class="fw-bold mb-3">Filter Level Wise Member List</h5>
  <form method="GET" action="{{ route('team.level') }}" class="row g-3">
    <div class="col-lg-3 col-md-6"><label class="form-label" for="level">Select Level</label><select class="form-select" id="level" name="level"><option value="">All Levels</option>@foreach(range(1, $maxLevels) as $level)<option value="{{ $level }}" @selected((string) request('level') === (string) $level)>Level {{ $level }}</option>@endforeach</select></div>
    <div class="col-lg-3 col-md-6"><label class="form-label" for="package">Package Status</label><select class="form-select" id="package" name="package"><option value="">All Statuses</option>@foreach(['Zenith' => 'Zenith Package', 'Inactive' => 'Not Purchased'] as $value => $label)<option value="{{ $value }}" @selected(request('package') === $value)>{{ $label }}</option>@endforeach</select></div>
    <div class="col-lg-4 col-md-6"><label class="form-label" for="search">Search</label><input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Member ID / Name / Mobile"></div>
    <div class="col-lg-2 col-md-6 d-flex align-items-end"><button class="btn btn-main w-100" type="submit">Search</button></div>
  </form>
</div>

<div class="card-box">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><div><h5 class="fw-bold mb-1">Level Wise Member List</h5><small>Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() }} members</small></div><a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('team.level') }}">Reset</a></div>
  <div class="table-responsive"><table class="table table-bordered align-middle">
    <thead><tr><th>SL</th><th>Photo</th><th>Member ID</th><th>Name</th><th>Mobile</th><th>Level</th><th>Sponsor ID</th><th>Package</th><th>Joining Date</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>@forelse($members as $member)
      @php($packageType = $member->package_type)
      @php($photoUrl = $member->profile?->profile_photo ? asset($member->profile->profile_photo) : asset('images/profile-placeholder.svg'))
      <tr><td>{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td><td><img class="member-img" src="{{ $photoUrl }}" alt="{{ $member->name }}"></td><td>{{ $member->member_id ?: '-' }}</td><td>{{ $member->name }}</td><td>{{ $member->mobile ?: '-' }}</td><td>Level {{ $member->team_level }}</td><td>{{ $member->sponsor_id ?: '-' }}</td><td><span class="badge badge-{{ strtolower($packageType) }}">{{ $packageType === 'Inactive' ? 'Not Purchased' : $packageType }}</span></td><td>{{ optional($member->created_at)->format('d M Y') ?: '-' }}</td><td><span class="badge {{ $packageType === 'Inactive' ? 'bg-danger' : 'bg-success' }}">{{ $packageType === 'Inactive' ? 'Inactive' : 'Active' }}</span></td><td><a href="{{ route('team.member.details', $member->id) }}" class="btn btn-sm btn-outline-primary">View</a></td></tr>
    @empty<tr><td colspan="11" class="text-center text-muted py-4">No team members found for the selected filters.</td></tr>@endforelse</tbody>
  </table></div>
  <div class="mt-3">{{ $members->links() }}</div>
</div>
@endsection
