@extends('layouts.app')

@section('title', 'Monthly Zenith Pool Income')
@section('page-title', 'Monthly Zenith Pool Income')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:48px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.pool-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:100%}
.pool-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.pool-row span:last-child{font-weight:700;text-align:right;color:#ffe799}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-paid{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-process{background:#e8f0ff;color:#0d6efd}
.badge-hold{background:#fde2e2;color:#dc3545}
.search-label{font-size:13px;font-weight:700;color:#555}
.formula-card{background:#fff;border-radius:18px;box-shadow:0 8px 25px rgba(0,0,0,.07);overflow:hidden}
.formula-card .step{padding:18px;border-right:1px solid #eee;text-align:center}
.formula-card .step:last-child{border-right:0}
.formula-card h5{font-weight:900;color:var(--primary)}

@media(max-width:576px){.pool-row{display:block}.pool-row span:last-child{text-align:left;display:block;margin-top:5px}.page-}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Pool Income</p><h3>₹12,500</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month Pool</p><h3>₹4,000</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month Share</p><h3 class="text-success">₹400</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pool Status</p><h3 class="text-warning">Pending</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Income Rule:</b> Every month, 5% of total Zenith package purchase amount will be added into the Monthly Zenith Pool. The pool amount will be divided equally among total Zenith package purchasers and distributed once every month.
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-5">
        <div class="pool-box">
          <h4 class="fw-bold mb-3"><i class="fa fa-crown"></i> Current Month Pool Details</h4>

          <div class="pool-row"><span>Income Name</span><span>Monthly Zenith Pool Income</span></div>
          <div class="pool-row"><span>Month</span><span>June 2026</span></div>
          <div class="pool-row"><span>Total Zenith Package Sale</span><span>₹80,000</span></div>
          <div class="pool-row"><span>Pool Percentage</span><span>5%</span></div>
          <div class="pool-row"><span>Total Pool Amount</span><span>₹4,000</span></div>
          <div class="pool-row"><span>Total Purchasers</span><span>10</span></div>
          <div class="pool-row"><span>Your Monthly Share</span><span>₹400</span></div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card-box h-100">
          <h5 class="fw-bold mb-3">Search Monthly Pool Income</h5>
          <form onsubmit="filterReport(event)">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="search-label">From Month</label>
                <input type="month" class="form-control" id="fromMonth" value="2026-04">
              </div>
              <div class="col-md-6">
                <label class="search-label">To Month</label>
                <input type="month" class="form-control" id="toMonth" value="2026-06">
              </div>
              <div class="col-md-6">
                <label class="search-label">Status</label>
                <select class="form-select" id="statusFilter">
                  <option value="">All Status</option>
                  <option>Paid</option>
                  <option>Pending</option>
                  <option>Processing</option>
                  <option>Hold</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="search-label">Member ID</label>
                <input type="text" class="form-control" placeholder="Enter member ID">
              </div>
              <div class="col-12 d-flex gap-2 flex-wrap mt-2">
                <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
                <button type="reset" class="btn btn-secondary rounded-pill px-4">Reset</button>
                <button type="button" class="btn btn-gold" onclick="exportReport()"><i class="fa fa-file-export"></i> Export</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="formula-card mb-4">
      <div class="row g-0">
        <div class="col-lg-3 col-md-6 step">
          <small>Total Zenith Package Sale</small>
          <h5>₹80,000</h5>
        </div>
        <div class="col-lg-3 col-md-6 step">
          <small>Pool Percentage</small>
          <h5>5%</h5>
        </div>
        <div class="col-lg-3 col-md-6 step">
          <small>Pool Amount</small>
          <h5>₹4,000</h5>
        </div>
        <div class="col-lg-3 col-md-6 step">
          <small>Share Formula</small>
          <h5>₹4,000 ÷ 10 = ₹400</h5>
        </div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">Month Wise Zenith Pool Income List</h5>
        <span class="badge badge-process px-3 py-2">Income: Monthly Zenith Pool Income</span>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>SL</th>
              <th>Month</th>
              <th>Member ID</th>
              <th>Member Name</th>
              <th>Total Zenith Package Amount</th>
              <th>Pool %</th>
              <th>Total Pool Amount</th>
              <th>Total Purchasers</th>
              <th>Per Purchaser Income</th>
              <th>TDS / Charge</th>
              <th>Net Income</th>
              <th>Status</th>
              <th>Credit Date</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody id="incomeTable">
            <tr>
              <td>1</td>
              <td>June 2026</td>
              <td>ARM1001</td>
              <td>Member Name</td>
              <td>₹80,000</td>
              <td>5%</td>
              <td>₹4,000</td>
              <td>10</td>
              <td>₹400</td>
              <td>₹0</td>
              <td>₹400</td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td>-</td>
              <td>Will be distributed month end</td>
            </tr>
            <tr>
              <td>2</td>
              <td>May 2026</td>
              <td>ARM1001</td>
              <td>Member Name</td>
              <td>₹1,50,000</td>
              <td>5%</td>
              <td>₹7,500</td>
              <td>15</td>
              <td>₹500</td>
              <td>₹0</td>
              <td>₹500</td>
              <td><span class="badge badge-paid">Paid</span></td>
              <td>31 May 2026</td>
              <td>Credited to earn wallet</td>
            </tr>
            <tr>
              <td>3</td>
              <td>April 2026</td>
              <td>ARM1001</td>
              <td>Member Name</td>
              <td>₹2,00,000</td>
              <td>5%</td>
              <td>₹10,000</td>
              <td>20</td>
              <td>₹500</td>
              <td>₹0</td>
              <td>₹500</td>
              <td><span class="badge badge-paid">Paid</span></td>
              <td>30 Apr 2026</td>
              <td>Monthly pool distributed</td>
            </tr>
            <tr>
              <td>4</td>
              <td>March 2026</td>
              <td>ARM1001</td>
              <td>Member Name</td>
              <td>₹1,20,000</td>
              <td>5%</td>
              <td>₹6,000</td>
              <td>12</td>
              <td>₹500</td>
              <td>₹0</td>
              <td>₹500</td>
              <td><span class="badge badge-paid">Paid</span></td>
              <td>31 Mar 2026</td>
              <td>Paid successfully</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
