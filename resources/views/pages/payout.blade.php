@extends('layouts.app')

@section('title', 'Create Payout Request')
@section('page-title', 'Create Payout Request')

@push('styles')
<style>
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{min-height:48px;border-radius:12px}
textarea.form-control{min-height:95px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.bank-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:100%}
.bank-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.bank-row span:last-child{font-weight:700;text-align:right}
.payout-history-table{table-layout:fixed;min-width:900px;margin-bottom:0}
.payout-history-table thead th{background:var(--primary);color:#fff;white-space:nowrap;vertical-align:middle}
.payout-history-table th:nth-child(1){width:19%}
.payout-history-table th:nth-child(2){width:18%}
.payout-history-table th:nth-child(3){width:13%}
.payout-history-table th:nth-child(4){width:14%}
.payout-history-table th:nth-child(5){width:12%}
.payout-history-table th:nth-child(6){width:24%}
.payout-history-table td{vertical-align:middle;white-space:normal;overflow-wrap:anywhere;word-break:normal}
.payout-history-table td:last-child{min-width:190px}
@media(max-width:767px){
  .bank-row{display:block}.bank-row span:last-child{text-align:left;display:block;margin-top:5px}
  .card-box{padding:18px}
  .payout-history-wrap{overflow:visible}
  .payout-history-table{display:block;min-width:0;width:100%;table-layout:auto;border:0}
  .payout-history-table thead{display:none}
  .payout-history-table tbody{display:grid;gap:14px}
  .payout-history-table tr{display:block;border:1px solid #e5e7eb;border-radius:14px;padding:8px 14px;background:#fff;box-shadow:0 4px 14px rgba(0,0,0,.05)}
  .payout-history-table td{display:grid;grid-template-columns:minmax(105px,38%) minmax(0,1fr);gap:12px;width:100%;padding:10px 0;border:0;border-bottom:1px solid #edf0f2;text-align:right;white-space:normal;overflow-wrap:anywhere}
  .payout-history-table td:last-child{min-width:0;border-bottom:0}
  .payout-history-table td::before{content:attr(data-label);font-weight:700;color:#495057;text-align:left}
  .payout-history-table td.payout-empty{display:block;text-align:center;padding:22px 0}
  .payout-history-table td.payout-empty::before{display:none}
}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Available Earn Wallet</p><h3>₹{{ number_format((float) $user->earning_wallet, 2) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Minimum Payout</p><h3>₹{{ number_format($minimumAmount, 2) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending Payout</p><h3 class="text-warning">₹{{ number_format($pendingAmount, 2) }}</h3></div></div>
  <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Paid</p><h3 class="text-success">₹{{ number_format($totalPaid, 2) }}</h3></div></div>
</div>

@if(! $isPackageActive || ! $isKycApproved)
  <div class="alert alert-danger rounded-4 mb-4">
    <h6 class="fw-bold"><i class="fa fa-circle-exclamation me-1"></i> Payout request is currently unavailable</h6>
    <ul class="mb-0">
      @unless($isPackageActive)<li>You must purchase an active package first.</li>@endunless
      @unless($isKycApproved)<li>Your KYC must be approved by admin first. Current status: {{ $kyc->status ?? 'Not Submitted' }}.</li>@endunless
    </ul>
  </div>
@else
  <div class="info-note mb-4">
    <b>Eligible:</b> Your package is active and KYC is approved. The requested amount is reserved from your earning wallet immediately; it is returned automatically if admin rejects the request.
  </div>
@endif

<div class="row g-4">
  <div class="col-lg-5">
    <div class="bank-box">
      <h4 class="fw-bold mb-3"><i class="fa fa-building-columns"></i> Approved Bank Details</h4>
      <div class="bank-row"><span>Account Holder</span><span>{{ $kyc->account_holder_name ?? 'Not Provided' }}</span></div>
      <div class="bank-row"><span>Bank Name</span><span>{{ $kyc->bank_name ?? 'Not Provided' }}</span></div>
      <div class="bank-row">
        <span>Account Number</span>
        <span>
          @if(filled($kyc?->account_number))
            ••••{{ substr((string) $kyc->account_number, -4) }}
          @else
            Not Provided
          @endif
        </span>
      </div>
      <div class="bank-row"><span>IFSC Code</span><span>{{ $kyc->ifsc_code ?? 'Not Provided' }}</span></div>
      <div class="bank-row"><span>KYC Status</span><span>{{ $kyc->status ?? 'Not Submitted' }}</span></div>
      <div class="mt-4"><a href="{{ route('kyc') }}" class="btn btn-light rounded-pill px-4"><i class="fa fa-pen"></i> View Bank / KYC</a></div>
    </div>

    <div class="card-box mt-4">
      <h5 class="fw-bold mb-3">Payout Rules</h5>
      <ul class="mb-0">
        <li>Active package and approved KYC are mandatory.</li>
        <li>Minimum payout amount is ₹{{ number_format($minimumAmount, 2) }}.</li>
        <li>The request cannot exceed the available earning wallet.</li>
        <li>Payment details are captured with the request for admin review.</li>
      </ul>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card-box">
      <h5 class="fw-bold mb-3">Place Payout Request</h5>

      <form method="POST" action="{{ route('payout.request.post') }}">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Available Earn Wallet</label>
            <input type="text" class="form-control" value="₹{{ number_format((float) $user->earning_wallet, 2) }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Request Amount</label>
            <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" min="{{ $minimumAmount }}" max="{{ (float) $user->earning_wallet }}" step="0.01" placeholder="Minimum ₹{{ number_format($minimumAmount) }}" required @disabled(! $isPackageActive || ! $isKycApproved)>
            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Payout Mode</label>
            <select name="mode" id="mode" class="form-select @error('mode') is-invalid @enderror" required @disabled(! $isPackageActive || ! $isKycApproved)>
              <option value="">Select Mode</option>
              <option value="Bank Transfer" @selected(old('mode') === 'Bank Transfer')>Bank Transfer</option>
              <option value="UPI" @selected(old('mode') === 'UPI')>UPI</option>
            </select>
            @error('mode')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 d-none" id="upiField">
            <label class="form-label">UPI ID</label>
            <input type="text" name="upi_id" class="form-control @error('upi_id') is-invalid @enderror" value="{{ old('upi_id') }}" maxlength="100" placeholder="name@bank" @disabled(! $isPackageActive || ! $isKycApproved)>
            @error('upi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Charge</label>
            <input type="text" class="form-control" value="₹0.00" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Net Payable</label>
            <input type="text" id="netPayable" class="form-control" value="₹0.00" readonly>
          </div>
          <div class="col-12">
            <label class="form-label">Remark (optional)</label>
            <textarea name="member_remark" class="form-control @error('member_remark') is-invalid @enderror" maxlength="500" placeholder="Add a note for admin" @disabled(! $isPackageActive || ! $isKycApproved)>{{ old('member_remark') }}</textarea>
            @error('member_remark')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input @error('details_confirmed') is-invalid @enderror" type="checkbox" name="details_confirmed" value="1" id="detailsConfirmed" @checked(old('details_confirmed')) required @disabled(! $isPackageActive || ! $isKycApproved)>
              <label class="form-check-label" for="detailsConfirmed">I confirm that my payout and KYC details are correct.</label>
              @error('details_confirmed')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-12 d-flex gap-2 flex-wrap">
            <button class="btn btn-main" @disabled(! $isPackageActive || ! $isKycApproved)><i class="fa fa-paper-plane"></i> Submit Payout Request</button>
            <a href="{{ route('payout.list') }}" class="btn btn-outline-secondary rounded-pill px-4">View All Requests</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card-box mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Recent Payout Requests</h5>
    <a href="{{ route('payout.list') }}" class="btn btn-sm btn-outline-dark">Full History</a>
  </div>
  <div class="table-responsive payout-history-wrap">
    <table class="table table-bordered align-middle payout-history-table">
      <thead><tr><th>Request</th><th>Date</th><th>Amount</th><th>Mode</th><th>Status</th><th>Admin Remark</th></tr></thead>
      <tbody>
        @forelse($recentPayouts as $payout)
          @php($badge = match($payout->status) {'Approved' => 'success', 'Rejected' => 'danger', default => 'warning'})
          <tr>
            <td data-label="Request">{{ $payout->request_no }}</td>
            <td data-label="Date">{{ $payout->created_at?->format('d M Y, h:i A') }}</td>
            <td data-label="Amount">₹{{ number_format((float) $payout->amount, 2) }}</td>
            <td data-label="Mode">{{ $payout->mode }}</td>
            <td data-label="Status"><span class="badge bg-{{ $badge }}">{{ $payout->status }}</span></td>
            <td data-label="Admin Remark">{{ $payout->admin_remark ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="payout-empty text-center py-4 text-muted">No payout requests yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
function updatePayoutFields(){
  const mode=document.getElementById('mode');
  const upiField=document.getElementById('upiField');
  const amount=document.getElementById('amount');
  const net=document.getElementById('netPayable');
  if(mode && upiField){upiField.classList.toggle('d-none',mode.value!=='UPI');}
  if(amount && net){net.value='₹'+Number(amount.value||0).toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2});}
}
document.getElementById('mode')?.addEventListener('change',updatePayoutFields);
document.getElementById('amount')?.addEventListener('input',updatePayoutFields);
updatePayoutFields();
</script>
@endpush
