@extends('layouts.app')

@section('title', 'Create Payout Request')
@section('page-title', 'Create Payout Request')

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
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.bank-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:100%}
.bank-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.bank-row span:last-child{font-weight:700;text-align:right}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-pending{background:#fff3cd;color:#856404}
.badge-approved{background:#dff7e8;color:#198754}
.badge-rejected{background:#fde2e2;color:#dc3545}
@media(max-width:991px){}
@media(max-width:576px){.bank-row{display:block}.bank-row span:last-child{text-align:left;display:block;margin-top:5px}}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Earn Wallet</p><h3>₹8,750</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Minimum Payout</p><h3>₹500</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending Payout</p><h3 class="text-warning">₹2,000</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Paid</p><h3 class="text-success">₹18,000</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Note:</b> Payout request will be deducted from your Earn Wallet. Admin will verify KYC and bank details before payment approval.
    </div>

    <div class="row g-4">
      <div class="col-lg-5">
        <div class="bank-box">
          <h4 class="fw-bold mb-3"><i class="fa fa-building-columns"></i> Your Bank Details</h4>

          <div class="bank-row">
            <span>Account Holder</span>
            <span>Member Name</span>
          </div>

          <div class="bank-row">
            <span>Bank Name</span>
            <span>State Bank of India</span>
          </div>

          <div class="bank-row">
            <span>Account Number</span>
            <span>XXXXXX7890</span>
          </div>

          <div class="bank-row">
            <span>IFSC Code</span>
            <span>SBIN0001234</span>
          </div>

          <div class="bank-row">
            <span>UPI ID</span>
            <span>member@upi</span>
          </div>

          <div class="bank-row">
            <span>KYC Status</span>
            <span>Verified</span>
          </div>

          <div class="mt-4">
            <a href="{{ route('kyc') }}" class="btn btn-gold"><i class="fa fa-pen"></i> Update Bank / KYC</a>
          </div>
        </div>

        <div class="card-box mt-4">
          <h5 class="fw-bold mb-3">Payout Rules</h5>
          <ul class="mb-0">
            <li>Minimum payout amount: ₹500</li>
            <li>KYC must be verified before payout.</li>
            <li>Payout request may take 24–72 working hours.</li>
            <li>Incorrect bank details may delay payment.</li>
            <li>Admin charges/TDS can be applied as per company rules.</li>
          </ul>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card-box">
          <h5 class="fw-bold mb-3">Place Payout Request</h5>

          <form onsubmit="submitPayout(event)">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Available Earn Wallet</label>
                <input type="text" class="form-control" value="₹8,750" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">Request Amount</label>
                <input type="number" class="form-control" id="amount" placeholder="Enter payout amount" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Payout Mode</label>
                <select class="form-select" id="mode" required>
                  <option value="">Select Mode</option>
                  <option>Bank Transfer</option>
                  <option>UPI</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Estimated Charge</label>
                <input type="text" class="form-control" id="charge" value="₹0" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">Net Payable</label>
                <input type="text" class="form-control" id="netPayable" value="₹0" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">Security PIN</label>
                <input type="password" class="form-control" placeholder="Enter transaction PIN">
              </div>

              <div class="col-12">
                <label class="form-label">Remark</label>
                <textarea class="form-control" id="remark" placeholder="Write your note"></textarea>
              </div>

              <div class="col-12">
                <label>
                  <input type="checkbox" required> I confirm that my bank/KYC details are correct.
                </label>
              </div>

              <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-main"><i class="fa fa-paper-plane"></i> Submit Payout Request</button>
                <button type="reset" class="btn btn-secondary rounded-pill px-4">Reset</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="card-box mt-4">
      <h5 class="fw-bold mb-3">Recent Payout Requests</h5>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>SL</th>
              <th>Request Date</th>
              <th>Amount</th>
              <th>Charge</th>
              <th>Net Payable</th>
              <th>Mode</th>
              <th>Status</th>
              <th>Admin Remark</th>
            </tr>
          </thead>

          <tbody id="payoutTable">
            <tr>
              <td>1</td>
              <td>28 Jun 2026</td>
              <td>₹2,000</td>
              <td>₹0</td>
              <td>₹2,000</td>
              <td>Bank Transfer</td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td>Under verification</td>
            </tr>

            <tr>
              <td>2</td>
              <td>25 Jun 2026</td>
              <td>₹5,000</td>
              <td>₹0</td>
              <td>₹5,000</td>
              <td>UPI</td>
              <td><span class="badge badge-approved">Approved</span></td>
              <td>Paid successfully</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
