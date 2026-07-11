@extends('layouts.app')

@section('title', 'Direct Member List')
@section('page-title', 'Direct Member List')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:46px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.btn-main:hover{background:var(--dark);color:#fff}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.member-img{width:42px;height:42px;border-radius:50%;object-fit:cover}
.badge-active{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total Direct</p>
          <h3>18</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Active Direct</p>
          <h3>12</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Pending Package</p>
          <h3>6</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Zenith Members</p>
          <h3>4</h3>
        </div>
      </div>
    </div>

    <div class="card-box mb-4">
    <h5 class="fw-bold mb-3">Search / Filter Members</h5>

    <form method="GET" action="{{ route('team.direct') }}">
        <div class="row g-3">

            <div class="col-lg-4">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by Name, Member ID or Mobile"
                    value="{{ request('search') }}">
            </div>

            <div class="col-lg-3">
                <select name="package" class="form-select">

                    <option value="">All Package Status</option>

                    <option value="Not Purchased"
                        {{ request('package')=='Not Purchased' ? 'selected' : '' }}>
                        Not Purchased
                    </option>

                    <option value="Basic Package"
                        {{ request('package')=='Basic Package' ? 'selected' : '' }}>
                        Basic Package
                    </option>

                    <option value="Zenith Package"
                        {{ request('package')=='Zenith Package' ? 'selected' : '' }}>
                        Zenith Package
                    </option>

                </select>
            </div>

            <div class="col-lg-3">

                <select name="status" class="form-select">

                    <option value="">All Status</option>

                    <option value="1"
                        {{ request('status')=='1' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ request('status')=='0' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="2"
                        {{ request('status')=='2' ? 'selected' : '' }}>
                        Blocked
                    </option>

                </select>

            </div>

            <div class="col-lg-2 d-grid">
                <button class="btn btn-main">
                    Search
                </button>
            </div>

        </div>
    </form>
</div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h5 class="fw-bold mb-2">Direct Members</h5>
        <div>
          <button class="btn btn-outline-secondary btn-sm rounded-pill"><i class="fa fa-file-excel"></i> Export</button>
          <a href="add-member.html" class="btn btn-main btn-sm"><i class="fa fa-user-plus"></i> Add Member</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>SL</th>
              <th>Photo</th>
              <th>Member ID</th>
              <th>Name</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>Sponsor ID</th>
              <th>Joining Date</th>
              <th>Package</th>
              <th>KYC</th>
              <th>Status</th>
              <th>Total Team</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          
            @forelse($members as $member)

            <tr>

                <td>
                    {{ $loop->iteration + ($members->currentPage()-1) * $members->perPage() }}
                </td>

                <td>
                    <img
                        src="{{ $member->profile_photo ? asset('storage/'.$member->profile_photo) : asset('images/default-user.png') }}"
                        class="member-img">
                </td>

                <td>{{ $member->member_id }}</td>

                <td>{{ $member->name }}</td>

                <td>{{ $member->mobile }}</td>

                <td>{{ $member->email ?? '-' }}</td>

                <td>{{ optional($member->sponsor)->member_id }}</td>

                <td>{{ $member->created_at->format('d M Y') }}</td>

                <td>

                    @if($member->package_name)

                        <span class="badge bg-success">
                            {{ $member->package_name }}
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            Not Purchased
                        </span>

                    @endif

                </td>

                <td>

                    @if($member->kyc_status=='verified')

                        <span class="badge bg-success">
                            Verified
                        </span>

                    @elseif($member->kyc_status=='rejected')

                        <span class="badge bg-danger">
                            Rejected
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>

                    @endif

                </td>

                <td>

                    @if($member->status=='active')

                        <span class="badge bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>

                    @endif

                </td>

                <td>

                    {{ $member->children_count }}

                </td>

                <td>

                    <button
                        class="btn btn-sm btn-outline-primary viewMemberBtn"
                        data-id="{{ $member->id }}"
                        data-bs-toggle="modal"
                        data-bs-target="#viewModal">
                        View
                    </button>

                </td>

            </tr>

            @empty

            <tr>

            <td colspan="13" class="text-center">

            No Members Found.

            </td>

            </tr>

            @endforelse

            </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-3">

        <small>

            Showing

            {{ $members->firstItem() ?? 0 }}

            to

            {{ $members->lastItem() ?? 0 }}

            of

            {{ $members->total() }}

            entries

        </small>

        {{ $members->withQueryString()->links() }}

    </div>
    </div>

  </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Member Details</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row g-4">

                    <div class="col-md-4 text-center">

                        <img
                            src="{{ $member->profile && $member->profile->photo ? asset('storage/'.$member->profile->photo) : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' }}"
                            class="rounded-circle border"
                            style="width:110px;height:110px;object-fit:cover;">

                        <h5 class="mt-3 mb-1">
                            {{ $member->name }}
                        </h5>

                        <span class="badge bg-primary">
                            {{ $member->member_id }}
                        </span>

                    </div>

                    <div class="col-md-8">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <strong>Mobile</strong><br>
                                {{ $member->mobile }}
                            </div>

                            <div class="col-md-6">
                                <strong>Email</strong><br>
                                {{ $member->email ?? '-' }}
                            </div>

                            <div class="col-md-6">
                                <strong>Sponsor ID</strong><br>
                                {{ $member->member_id ?? '-' }}
                            </div>

                            <div class="col-md-6">
                                <strong>Joining Date</strong><br>
                                {{ $member->created_at->format('d M Y') }}
                            </div>

                            <div class="col-md-6">
                                <strong>Package</strong><br>
                                {{ $member->package_name ?? 'Not Purchased' }}
                            </div>

                            <div class="col-md-6">
                                <strong>KYC</strong><br>

                                @if(optional($member->profile)->kyc_status)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif

                            </div>

                            <div class="col-md-6">
                                <strong>Status</strong><br>

                                @if($member->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif

                            </div>

                            <div class="col-md-6">
                                <strong>Total Team</strong><br>
                                {{-- $member->children()->count() --}} Members
                            </div>

                            <div class="col-12">
                                <strong>Address</strong><br>
                                {{ optional($member->profile)->address ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary rounded-pill"
                        data-bs-dismiss="modal">
                    Close
                </button>

                <a href=""
                   class="btn btn-main">
                    View Team
                </a>

            </div>

        </div>
    </div>
</div>
@endsection
