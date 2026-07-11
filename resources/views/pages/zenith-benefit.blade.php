@extends('layouts.app')

@section('title', 'Zenith Package Benefit Income Report')
@section('page-title', 'Zenith Package Benefit Income Report')

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
.benefit-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:100%}
.benefit-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.benefit-row span:last-child{font-weight:700;text-align:right;color:#ffe799}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-paid{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-hold{background:#fde2e2;color:#dc3545}
.badge-credit{background:#e8f0ff;color:#0d6efd}
.search-label{font-size:13px;font-weight:700;color:#555}
.total-strip{background:#fff;border-radius:18px;box-shadow:0 8px 25px rgba(0,0,0,.07);overflow:hidden}
.total-strip .item{padding:20px;border-right:1px solid #eee}
.total-strip .item:last-child{border-right:0}
.total-strip h4{color:var(--primary);font-weight:900;margin-bottom:0}
@media(max-width:991px){}
@media(max-width:576px){.benefit-row{display:block}.benefit-row span:last-child{text-align:left;display:block;margin-top:5px}.page-}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Zenith Purchases</p><h3 id="totalPurchase">18</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Benefit Per Purchase</p><h3>₹250</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Income</p><h3 id="totalIncome">₹4,500</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Paid Income</p><h3 class="text-success" id="paidIncome">₹3,750</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Income Rule:</b> ₹250 Zenith Package Benefit will be credited one time for every Zenith package purchase. Each purchase generates a single benefit entry only.
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-4">
        <div class="benefit-box">
          <h4 class="fw-bold mb-3"><i class="fa fa-gift"></i> Zenith Benefit Details</h4>
          <div class="benefit-row"><span>Package Name</span><span>Zenith Package</span></div>
          <div class="benefit-row"><span>Benefit Amount</span><span>₹250</span></div>
          <div class="benefit-row"><span>Benefit Type</span><span>Single Time</span></div>
          <div class="benefit-row"><span>Applicable On</span><span>Every Purchase</span></div>
          <div class="benefit-row"><span>Credit Wallet</span><span>Earn Wallet</span></div>
          <div class="mt-4">
            <a href="#reportTable" class="btn btn-gold"><i class="fa fa-list"></i> View Report</a>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card-box">
          <h5 class="fw-bold mb-3">Search / Filter Report</h5>
          <div class="row g-3">
            <div class="col-md-4">
              <label class="search-label">From Date</label>
              <input type="date" class="form-control" id="fromDate">
            </div>
            <div class="col-md-4">
              <label class="search-label">To Date</label>
              <input type="date" class="form-control" id="toDate">
            </div>
            <div class="col-md-4">
              <label class="search-label">Status</label>
              <select class="form-select" id="statusFilter">
                <option value="All">All Status</option>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Hold">Hold</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="search-label">Search Member / Order ID</label>
              <input type="text" class="form-control" id="searchBox" placeholder="Enter member name, ID or order no.">
            </div>
            <div class="col-md-6 d-flex align-items-end gap-2 flex-wrap">
              <button class="btn btn-main" onclick="filterReport()"><i class="fa fa-magnifying-glass"></i> Search</button>
              <button class="btn btn-secondary rounded-pill px-4" onclick="resetFilter()">Reset</button>
              <button class="btn btn-gold" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row total-strip mb-4 text-center">
      <div class="col-md-3 col-6 item"><small>Filtered Purchases</small><h4 id="filteredPurchase">18</h4></div>
      <div class="col-md-3 col-6 item"><small>Filtered Income</small><h4 id="filteredIncome">₹4,500</h4></div>
      <div class="col-md-3 col-6 item"><small>Pending Amount</small><h4 class="text-warning" id="pendingIncome">₹500</h4></div>
      <div class="col-md-3 col-6 item"><small>Hold Amount</small><h4 class="text-danger" id="holdIncome">₹250</h4></div>
    </div>

    <div class="card-box" id="reportTable">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">Zenith Package Benefit Income List</h5>
        <span class="badge badge-credit px-3 py-2">₹250 Single Time / Purchase</span>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="zenithTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Order ID</th>
              <th>Buyer ID</th>
              <th>Buyer Name</th>
              <th>Package</th>
              <th>Package Amount</th>
              <th>Benefit</th>
              <th>Wallet</th>
              <th>Status</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody>
            <tr data-date="2026-06-29" data-status="Paid"><td>1</td><td>29 Jun 2026</td><td>ZEN10029</td><td>ARM1025</td><td>Rahul Sharma</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-paid">Paid</span></td><td>Benefit credited</td></tr>
            <tr data-date="2026-06-28" data-status="Paid"><td>2</td><td>28 Jun 2026</td><td>ZEN10028</td><td>ARM1041</td><td>Priya Das</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-paid">Paid</span></td><td>Benefit credited</td></tr>
            <tr data-date="2026-06-27" data-status="Pending"><td>3</td><td>27 Jun 2026</td><td>ZEN10027</td><td>ARM1058</td><td>Amit Roy</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-pending">Pending</span></td><td>Under process</td></tr>
            <tr data-date="2026-06-26" data-status="Paid"><td>4</td><td>26 Jun 2026</td><td>ZEN10026</td><td>ARM1096</td><td>Suman Ghosh</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-paid">Paid</span></td><td>Benefit credited</td></tr>
            <tr data-date="2026-06-25" data-status="Hold"><td>5</td><td>25 Jun 2026</td><td>ZEN10025</td><td>ARM1110</td><td>Neha Singh</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-hold">Hold</span></td><td>KYC verification pending</td></tr>
            <tr data-date="2026-06-24" data-status="Paid"><td>6</td><td>24 Jun 2026</td><td>ZEN10024</td><td>ARM1128</td><td>Arjun Pal</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-paid">Paid</span></td><td>Benefit credited</td></tr>
            <tr data-date="2026-06-23" data-status="Pending"><td>7</td><td>23 Jun 2026</td><td>ZEN10023</td><td>ARM1150</td><td>Mitali Sen</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-pending">Pending</span></td><td>Under process</td></tr>
            <tr data-date="2026-06-22" data-status="Paid"><td>8</td><td>22 Jun 2026</td><td>ZEN10022</td><td>ARM1162</td><td>Rohit Kumar</td><td>Zenith Package</td><td>₹10,000</td><td>₹250</td><td>Earn Wallet</td><td><span class="badge badge-paid">Paid</span></td><td>Benefit credited</td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
