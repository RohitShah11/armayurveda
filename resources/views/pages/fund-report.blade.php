@extends('layouts.app')

@section('title', 'Fund Request Record')
@section('page-title', 'Fund Request Record')

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
.info-row{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0;gap:18px}
.info-row span:last-child{text-align:right}
.proof-img{width:100%;max-height:280px;object-fit:contain;border:1px solid #eee;border-radius:16px;background:#fafafa}
.proof-box{min-height:220px;border:1px dashed #ddd;border-radius:16px;display:flex;align-items:center;justify-content:center;background:#fafafa;color:#777}
@media(max-width:576px){.card-box{padding:18px}.info-row{display:block}.info-row span:last-child{text-align:left;display:block;margin-top:4px}.table td,.table th{font-size:13px}}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
            <p>Total Requests</p>
            <h3>{{ $totalRequests }}</h3>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
            <p>Approved</p>
            <h3 class="text-success">{{ $approvedRequests }}</h3>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
            <p>Pending</p>
            <h3 class="text-warning">{{ $pendingRequests }}</h3>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
            <p>Rejected</p>
            <h3 class="text-danger">{{ $rejectedRequests }}</h3>
        </div>
    </div>
</div>

<div class="card-box mb-4">
    <h5 class="fw-bold mb-3">Filter Request Record</h5>

    <form method="GET" action="{{ route('fund.report') }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach(['Pending', 'Approved', 'Rejected'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Payment Mode</label>
                <select name="payment_mode" class="form-select">
                    <option value="">All</option>
                    @foreach(['UPI', 'Bank Transfer', 'QR Payment', 'Cash Deposit'] as $mode)
                        <option value="{{ $mode }}" {{ request('payment_mode') === $mode ? 'selected' : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Txn ID / remark">
            </div>

            <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-main" type="submit">
                    <i class="fa fa-search me-1"></i> Search
                </button>
                <a href="{{ route('fund.report') }}" class="btn btn-secondary rounded-pill px-4">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<div class="card-box">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
        <h5 class="fw-bold mb-0">Fund Request List</h5>
        <small class="text-muted">
            Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} requests
        </small>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Request ID</th>
                    <th>Request Date</th>
                    <th>Amount</th>
                    <th>Payment Mode</th>
                    <th>Transaction ID</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Admin Remark</th>
                    <th>Approved Date</th>
                    <th>Proof</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $fundRequest)
                    @php
                        $requestCode = $fundRequest->request_id ?: 'FR-' . str_pad($fundRequest->id, 6, '0', STR_PAD_LEFT);
                        $proofUrl = $fundRequest->payment_proof ? asset($fundRequest->payment_proof) : null;
                        $proofExtension = $fundRequest->payment_proof ? strtolower(pathinfo($fundRequest->payment_proof, PATHINFO_EXTENSION)) : null;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration + ($requests->firstItem() - 1) }}</td>
                        <td>{{ $requestCode }}</td>
                        <td>{{ optional($fundRequest->created_at)->format('d M Y') ?? '-' }}</td>
                        <td>INR {{ number_format($fundRequest->amount, 2) }}</td>
                        <td>{{ $fundRequest->payment_mode ?? '-' }}</td>
                        <td>{{ $fundRequest->transaction_id ?? '-' }}</td>
                        <td>{{ $fundRequest->payment_date ? \Carbon\Carbon::parse($fundRequest->payment_date)->format('d M Y') : '-' }}</td>
                        <td>
                            @if($fundRequest->status === 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($fundRequest->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($fundRequest->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-secondary">{{ $fundRequest->status ?? 'Unknown' }}</span>
                            @endif
                        </td>
                        <td>{{ $fundRequest->admin_remark ?? '-' }}</td>
                        <td>{{ $fundRequest->approved_at ? \Carbon\Carbon::parse($fundRequest->approved_at)->format('d M Y') : '-' }}</td>
                        <td>
                            @if($proofUrl)
                                <a href="{{ $proofUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-main btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $fundRequest->id }}">
                                Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center py-4">
                            <i class="fa fa-folder-open fa-2x text-muted mb-2"></i>
                            <br>
                            No fund request records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $requests->links() }}
    </div>
</div>

@foreach($requests as $fundRequest)
    @php
        $requestCode = $fundRequest->request_id ?: 'FR-' . str_pad($fundRequest->id, 6, '0', STR_PAD_LEFT);
        $proofUrl = $fundRequest->payment_proof ? asset($fundRequest->payment_proof) : null;
        $proofExtension = $fundRequest->payment_proof ? strtolower(pathinfo($fundRequest->payment_proof, PATHINFO_EXTENSION)) : null;
    @endphp
    <div class="modal fade" id="detailsModal{{ $fundRequest->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $fundRequest->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="detailsModalLabel{{ $fundRequest->id }}">Fund Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="info-row"><b>Request ID</b><span>{{ $requestCode }}</span></div>
                            <div class="info-row"><b>Request Date</b><span>{{ optional($fundRequest->created_at)->format('d M Y h:i A') ?? '-' }}</span></div>
                            <div class="info-row"><b>Amount</b><span>INR {{ number_format($fundRequest->amount, 2) }}</span></div>
                            <div class="info-row"><b>Payment Mode</b><span>{{ $fundRequest->payment_mode ?? '-' }}</span></div>
                            <div class="info-row"><b>Transaction ID</b><span>{{ $fundRequest->transaction_id ?? '-' }}</span></div>
                            <div class="info-row"><b>Depositor Name</b><span>{{ $fundRequest->depositor_name ?? '-' }}</span></div>
                            <div class="info-row"><b>Payment Date</b><span>{{ $fundRequest->payment_date ? \Carbon\Carbon::parse($fundRequest->payment_date)->format('d M Y') : '-' }}</span></div>
                            <div class="info-row"><b>Status</b><span>{{ $fundRequest->status ?? '-' }}</span></div>
                            <div class="info-row"><b>Member Remark</b><span>{{ $fundRequest->remark ?? '-' }}</span></div>
                            <div class="info-row"><b>Admin Remark</b><span>{{ $fundRequest->admin_remark ?? '-' }}</span></div>
                            <div class="info-row"><b>Approved Date</b><span>{{ $fundRequest->approved_at ? \Carbon\Carbon::parse($fundRequest->approved_at)->format('d M Y h:i A') : '-' }}</span></div>
                        </div>

                        <div class="col-md-5">
                            <h6 class="fw-bold">Payment Proof</h6>
                            @if($proofUrl)
                                @if(in_array($proofExtension, ['jpg', 'jpeg', 'png', 'webp']))
                                    <img class="proof-img" src="{{ $proofUrl }}" alt="Payment proof for {{ $requestCode }}">
                                @else
                                    <div class="proof-box">
                                        <i class="fa fa-file-pdf fa-3x"></i>
                                    </div>
                                @endif

                                <a href="{{ $proofUrl }}" target="_blank" class="btn btn-main w-100 mt-3">
                                    Open Proof
                                </a>
                            @else
                                <div class="proof-box">No proof uploaded</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
