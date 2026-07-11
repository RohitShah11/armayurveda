@extends('layouts.app')

@section('title', 'Mobile & DTH Recharge Cashback')
@section('page-title', 'Mobile & DTH Recharge Cashback')

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
.recharge-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:100%}
.recharge-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.recharge-row span:last-child{font-weight:700;text-align:right;color:#ffe799}
.operator-pill{background:var(--light);border:1px solid #ffd7e3;border-radius:16px;padding:14px;text-align:center;font-weight:700;color:var(--primary);height:100%;cursor:pointer;transition:.2s}
.operator-pill:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.08)}
.operator-pill i{display:block;font-size:24px;margin-bottom:8px;color:var(--gold)}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-success{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-failed{background:#fde2e2;color:#dc3545}
.badge-cashback{background:#fff5d6;color:#9a7400}
@media(max-width:991px){}
@media(max-width:576px){.recharge-row{display:block}.recharge-row span:last-child{text-align:left;display:block;margin-top:5px}}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Recharge Wallet</p><h3>₹3,250</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Recharge</p><h3>₹12,800</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Cashback</p><h3 class="text-success">₹640</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending Cashback</p><h3 class="text-warning">₹75</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Note:</b> Cashback will be credited after successful recharge verification. Cashback percentage may vary by operator, plan, and company rules.
    </div>

    <div class="row g-4">
      <div class="col-lg-4">
        <div class="recharge-box">
          <h4 class="fw-bold mb-3"><i class="fa fa-gift"></i> Cashback Benefits</h4>
          <div class="recharge-row"><span>Mobile Prepaid</span><span>Up to 5%</span></div>
          <div class="recharge-row"><span>Mobile Postpaid</span><span>Up to 3%</span></div>
          <div class="recharge-row"><span>DTH Recharge</span><span>Up to 4%</span></div>
          <div class="recharge-row"><span>Minimum Recharge</span><span>₹50</span></div>
          <div class="recharge-row"><span>Cashback Credit</span><span>Instant / 24 Hrs</span></div>
          <div class="recharge-row"><span>Status</span><span>Active</span></div>
        </div>

        <div class="card-box mt-4">
          <h5 class="fw-bold mb-3">Popular Services</h5>
          <div class="row g-3">
            <div class="col-6"><div class="operator-pill"><i class="fa fa-mobile-screen"></i>Prepaid</div></div>
            <div class="col-6"><div class="operator-pill"><i class="fa fa-file-invoice"></i>Postpaid</div></div>
            <div class="col-6"><div class="operator-pill"><i class="fa fa-satellite-dish"></i>DTH</div></div>
            <div class="col-6"><div class="operator-pill"><i class="fa fa-wallet"></i>Wallet</div></div>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card-box">
          <h5 class="fw-bold mb-3">Recharge Now</h5>

          <form onsubmit="submitRecharge(event)">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Recharge Type</label>
                <select class="form-select" id="rechargeType" required>
                  <option value="">Select Type</option>
                  <option>Mobile Prepaid</option>
                  <option>Mobile Postpaid</option>
                  <option>DTH Recharge</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Mobile / DTH Number</label>
                <input type="text" class="form-control" id="customerNumber" placeholder="Enter number / customer ID" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Operator</label>
                <select class="form-select" id="operator" required>
                  <option value="">Select Operator</option>
                  <option>Airtel</option>
                  <option>Jio</option>
                  <option>Vi</option>
                  <option>BSNL</option>
                  <option>Tata Play</option>
                  <option>Dish TV</option>
                  <option>Airtel Digital TV</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Circle / State</label>
                <select class="form-select" id="circle" required>
                  <option value="">Select Circle</option>
                  <option>West Bengal</option>
                  <option>Odisha</option>
                  <option>Bihar & Jharkhand</option>
                  <option>Assam</option>
                  <option>Delhi NCR</option>
                  <option>Maharashtra</option>
                  <option>All India DTH</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Recharge Amount</label>
                <input type="number" class="form-control" id="amount" placeholder="Enter amount" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Estimated Cashback</label>
                <input type="text" class="form-control" id="cashback" value="₹0" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">Pay From</label>
                <select class="form-select" id="payFrom" required>
                  <option>Recharge Wallet</option>
                  <option>Earn Wallet</option>
                  <option>Online Payment</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Security PIN</label>
                <input type="password" class="form-control" placeholder="Enter transaction PIN">
              </div>

              <div class="col-12">
                <label class="form-label">Remark</label>
                <textarea class="form-control" id="remark" placeholder="Optional note"></textarea>
              </div>

              <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-main"><i class="fa fa-bolt"></i> Proceed Recharge</button>
                <button type="reset" class="btn btn-secondary rounded-pill px-4" onclick="resetCashback()">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card-box mt-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">Recharge Cashback History</h5>
        <div class="d-flex gap-2 flex-wrap">
          <input type="date" class="form-control" style="max-width:180px">
          <select class="form-select" style="max-width:170px">
            <option>All Status</option>
            <option>Success</option>
            <option>Pending</option>
            <option>Failed</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Type</th>
              <th>Number / ID</th>
              <th>Operator</th>
              <th>Amount</th>
              <th>Cashback</th>
              <th>Status</th>
              <th>Txn ID</th>
            </tr>
          </thead>
          <tbody id="rechargeTable">
            <tr>
              <td>1</td>
              <td>29 Jun 2026</td>
              <td>Mobile Prepaid</td>
              <td>98XXXXXX21</td>
              <td>Jio</td>
              <td>₹299</td>
              <td><span class="badge badge-cashback">₹15</span></td>
              <td><span class="badge badge-success">Success</span></td>
              <td>TXN984512</td>
            </tr>
            <tr>
              <td>2</td>
              <td>27 Jun 2026</td>
              <td>DTH Recharge</td>
              <td>30XXXXXX76</td>
              <td>Tata Play</td>
              <td>₹500</td>
              <td><span class="badge badge-cashback">₹20</span></td>
              <td><span class="badge badge-success">Success</span></td>
              <td>TXN984321</td>
            </tr>
            <tr>
              <td>3</td>
              <td>25 Jun 2026</td>
              <td>Mobile Postpaid</td>
              <td>90XXXXXX11</td>
              <td>Airtel</td>
              <td>₹399</td>
              <td><span class="badge badge-cashback">₹12</span></td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td>TXN983877</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
