@extends('layouts.admin')

@section('title', 'KYC Requests')
@section('page-title', 'KYC Requests')

@section('content')
<div class="admin-card mb-4">
  <form method="GET" action="{{ route('admin.kyc.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Search Member</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, member ID, mobile or email">
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">All</option>
          @foreach(['Pending', 'Approved', 'Rejected'] as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-main flex-fill"><i class="fa fa-search me-1"></i> Search</button>
        <a href="{{ route('admin.kyc.index') }}" class="btn btn-secondary rounded-pill px-4">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h5 class="fw-bold mb-0">KYC List</h5>
    <small class="text-muted">Showing {{ $kycs->firstItem() ?? 0 }} to {{ $kycs->lastItem() ?? 0 }} of {{ $kycs->total() }}</small>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Member</th>
          <th>PAN</th>
          <th>Aadhaar</th>
          <th>Bank</th>
          <th>Status</th>
          <th>Submitted</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kycs as $kyc)
          <tr>
            <td>
              <strong>{{ $kyc->user->name ?? '-' }}</strong><br>
              <small class="text-muted">{{ $kyc->user->member_id ?? '-' }}</small>
            </td>
            <td>{{ $kyc->pan_number ?? '-' }}</td>
            <td>{{ $kyc->aadhaar_number ?? '-' }}</td>
            <td>{{ $kyc->bank_name ?? '-' }}</td>
            <td><span class="badge bg-secondary">{{ $kyc->status ?? 'Pending' }}</span></td>
            <td>{{ optional($kyc->updated_at)->format('d M Y') ?? '-' }}</td>
            <td>
              <button class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#kycModal{{ $kyc->id }}">Review</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No KYC requests found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $kycs->links() }}</div>
</div>

@foreach($kycs as $kyc)
  <div class="modal fade" id="kycModal{{ $kyc->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content rounded-4">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Review KYC - {{ $kyc->user->name ?? 'Member' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-4">
            <div class="col-lg-7">
              <div class="detail-row"><b>Member ID</b><span>{{ $kyc->user->member_id ?? '-' }}</span></div>
              <div class="detail-row"><b>Mobile</b><span>{{ $kyc->user->mobile ?? '-' }}</span></div>
              <div class="detail-row"><b>PAN Number</b><span>{{ $kyc->pan_number ?? '-' }}</span></div>
              <div class="detail-row"><b>Aadhaar Number</b><span>{{ $kyc->aadhaar_number ?? '-' }}</span></div>
              <div class="detail-row"><b>Account Holder</b><span>{{ $kyc->account_holder_name ?? '-' }}</span></div>
              <div class="detail-row"><b>Bank Name</b><span>{{ $kyc->bank_name ?? '-' }}</span></div>
              <div class="detail-row"><b>Account Number</b><span>{{ $kyc->account_number ?? '-' }}</span></div>
              <div class="detail-row"><b>IFSC</b><span>{{ $kyc->ifsc_code ?? '-' }}</span></div>
              <div class="detail-row"><b>Branch</b><span>{{ $kyc->branch_name ?? '-' }}</span></div>
              <div class="detail-row"><b>Current Status</b><span>{{ $kyc->status ?? 'Pending' }}</span></div>
              <div class="detail-row"><b>Admin Remark</b><span>{{ $kyc->remarks ?? '-' }}</span></div>
            </div>
            <div class="col-lg-5">
              <h6 class="fw-bold">Documents</h6>
              <div class="row g-3">
                @foreach(['pan_image' => 'PAN Image', 'aadhaar_front' => 'Aadhaar Front', 'aadhaar_back' => 'Aadhaar Back', 'passbook_image' => 'Passbook'] as $field => $label)
                  <div class="col-sm-6">
                    <div class="border rounded-3 p-2 h-100">
                      <small class="fw-bold d-block mb-2">{{ $label }}</small>
                      @if($kyc->$field)
                        @php($extension = strtolower(pathinfo($kyc->$field, PATHINFO_EXTENSION)))
                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                          <img src="{{ asset($kyc->$field) }}" class="img-fluid rounded border mb-2" alt="{{ $label }}">
                        @else
                          <div class="p-4 text-center bg-light rounded mb-2"><i class="fa fa-file-pdf fa-2x"></i></div>
                        @endif
                        <a href="{{ asset($kyc->$field) }}" target="_blank" class="btn btn-sm btn-outline-dark w-100">Open</a>
                      @else
                        <div class="text-muted small">Not uploaded</div>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('admin.kyc.update', $kyc) }}" class="mt-4">
            @csrf
            @method('PATCH')
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Decision</label>
                <select name="status" class="form-select" required>
                  <option value="Approved">Approve</option>
                  <option value="Rejected">Reject</option>
                </select>
              </div>
              <div class="col-md-8">
                <label class="form-label">Remark</label>
                <input type="text" name="remarks" class="form-control" placeholder="Optional admin remark" value="{{ $kyc->remarks }}">
              </div>
              <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-main px-4">Submit Decision</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection
