@extends('layouts.app')

@section('title', 'Create Fund Request')
@section('page-title', 'Create Fund Request')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:48px;border-radius:12px}
textarea.form-control{height:95px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.account-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:auto}
.account-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.account-row span:last-child{font-weight:700;text-align:right}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-pending{background:#fff3cd;color:#856404}
.badge-approved{background:#dff7e8;color:#198754}
.badge-rejected{background:#fde2e2;color:#dc3545}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
@media(max-width:991px){}
@media(max-width:576px){.account-row{display:block}.account-row span:last-child{text-align:left;display:block;margin-top:5px}}

</style>
@endpush

@section('content')
<div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="card-box stat-card">
                <p>Main Wallet</p>
                <h3>₹{{ number_format(auth()->user()->main_wallet ?? 0, 2) }}</h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-box stat-card">
                <p>Total Requested</p>
                <h3>₹{{ number_format($totalRequested, 2) }}</h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-box stat-card">
                <p>Approved Fund</p>
                <h3 class="text-success">
                    ₹{{ number_format($approvedFund, 2) }}
                </h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-box stat-card">
                <p>Pending Fund</p>
                <h3 class="text-warning">
                    ₹{{ number_format($pendingFund, 2) }}
                </h3>
            </div>
        </div>

    </div>

    <div class="info-note mb-4">
      <b>Note:</b> Transfer money to company account first. Then submit fund request with transaction ID and payment proof. Admin will verify and credit your main wallet.
    </div>

    <div class="row g-4">
      <div class="col-lg-5">
        <div class="account-box">
          <h4 class="fw-bold mb-3"><i class="fa fa-building-columns"></i> Company Bank Account</h4>

          <div class="account-row">
            <span>Account Name</span>
            <span>ARM AYURVEDA PRIVATE LIMITED</span>
          </div>

          <div class="account-row">
            <span>Bank Name</span>
            <span>Ujjivan Small Finance Bank Ltd.</span>
          </div>

          <div class="account-row">
            <span>Account Number</span>
            <span>3579120040000073</span>
          </div>

          <div class="account-row">
            <span>IFSC Code</span>
            <span>UJVN0003579</span>
          </div>

          <div class="account-row">
            <span>Branch</span>
            <span>Purba Bardhaman</span>
          </div>

          <div class="mt-4 d-flex gap-2 flex-wrap">
            <button class="btn btn-gold" onclick="copyText('3579120040000073')"><i class="fa fa-copy"></i> Copy Account</button>
          </div>
        </div>

      </div>

      <div class="col-lg-7">
        <div class="card-box">

            <h5 class="fw-bold mb-3">
                Place Fund Request
            </h5>

            <form action="{{ route('fund.request.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row g-3">

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Request Amount <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               placeholder="Enter Amount"
                               value="{{ old('amount') }}">

                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Payment Mode -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Payment Mode <span class="text-danger">*</span>
                        </label>

                        <select name="payment_mode"
                                class="form-select @error('payment_mode') is-invalid @enderror">

                            <option value="">Select Payment Mode</option>

                            <option value="Bank Transfer"
                                {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>
                                Bank Transfer
                            </option>

                            <option value="UPI"
                                {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>
                                UPI
                            </option>

                            <option value="QR Payment"
                                {{ old('payment_mode') == 'QR Payment' ? 'selected' : '' }}>
                                QR Payment
                            </option>

                            <option value="Cash Deposit"
                                {{ old('payment_mode') == 'Cash Deposit' ? 'selected' : '' }}>
                                Cash Deposit
                            </option>

                        </select>

                        @error('payment_mode')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Transaction ID -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Transaction ID / UTR No. <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="transaction_id"
                               class="form-control @error('transaction_id') is-invalid @enderror"
                               placeholder="Enter Transaction ID"
                               value="{{ old('transaction_id') }}">

                        @error('transaction_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Payment Date -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Payment Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="payment_date"
                               class="form-control @error('payment_date') is-invalid @enderror"
                               value="{{ old('payment_date') }}">

                        @error('payment_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Depositor Name -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Depositor Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="depositor_name"
                               class="form-control @error('depositor_name') is-invalid @enderror"
                               placeholder="Enter Depositor Name"
                               value="{{ old('depositor_name', auth()->user()->name) }}">

                        @error('depositor_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Payment Proof -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Upload Payment Proof <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                               name="payment_proof"
                               class="form-control @error('payment_proof') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png,.pdf">

                        <small class="text-muted">
                            JPG, PNG or PDF (Max 4MB)
                        </small>

                        @error('payment_proof')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remark -->
                    <div class="col-12">
                        <label class="form-label">
                            Remark
                        </label>

                        <textarea name="remark"
                                  rows="4"
                                  class="form-control @error('remark') is-invalid @enderror"
                                  placeholder="Write any remark (Optional)">{{ old('remark') }}</textarea>

                        @error('remark')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirmation -->
                    <div class="col-12">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox"
                                   id="confirmPayment"
                                   required>

                            <label class="form-check-label" for="confirmPayment">

                                I confirm that I have successfully transferred the
                                payment to the company's bank account.

                            </label>

                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="col-12 d-flex gap-2 flex-wrap">

                        <button type="submit" class="btn btn-main">
                            <i class="fa fa-paper-plane me-1"></i>
                            Submit Request
                        </button>

                        <button type="reset"
                                class="btn btn-secondary rounded-pill px-4">
                            Reset
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>
    </div>

    <div class="card-box mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="fw-bold mb-0">
                Recent Fund Requests
            </h5>

            <span class="badge bg-primary">
                Total : {{ $fundRequests->total() }}
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Request Date</th>

                        <th>Amount</th>

                        <th>Payment Mode</th>

                        <th>Transaction ID</th>

                        <th>Payment Date</th>

                        <th>Proof</th>

                        <th>Status</th>

                        <th>Admin Remark</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($fundRequests as $request)

                    <tr>

                        <td>
                            {{ $loop->iteration + ($fundRequests->firstItem() - 1) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($request->created_at)->format('d M Y') }}
                        </td>

                        <td>
                            ₹{{ number_format($request->amount,2) }}
                        </td>

                        <td>
                            {{ $request->payment_mode }}
                        </td>

                        <td>
                            {{ $request->transaction_id }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($request->payment_date)->format('d M Y') }}
                        </td>

                        <td>

                            @if($request->payment_proof)

                                <a href="{{ asset($request->payment_proof) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-info">

                                    View

                                </a>

                            @else

                                --

                            @endif

                        </td>

                        <td>

                            @if($request->status=='Pending')

                                <span class="badge bg-warning">
                                    Pending
                                </span>

                            @elseif($request->status=='Approved')

                                <span class="badge bg-success">
                                    Approved
                                </span>

                            @elseif($request->status=='Rejected')

                                <span class="badge bg-danger">
                                    Rejected
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ $request->status }}
                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $request->admin_remark ?? '-' }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9" class="text-center py-4">

                            <i class="fa fa-folder-open fa-2x text-muted mb-2"></i>

                            <br>

                            No Fund Request Found.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $fundRequests->links() }}

        </div>

    </div>

  </div>
@endsection
