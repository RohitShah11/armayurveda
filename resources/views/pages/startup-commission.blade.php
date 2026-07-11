@extends('layouts.app')

@section('title', 'Startup Package Level Commission')
@section('page-title', 'Startup Package Level Commission')

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
.level-box{background:linear-gradient(135deg,var(--primary),var(--dark));color:#fff;border-radius:18px;padding:25px;height:100%}
.level-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:15px}
.level-row span:last-child{font-weight:700;text-align:right;color:#ffe799}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-paid{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-hold{background:#fde2e2;color:#dc3545}
.badge-level{background:var(--light);color:var(--primary);border:1px solid #f0cbd7}
.search-chip{background:#fff;border:1px solid #eee;border-radius:14px;padding:15px}
@media(max-width:991px){}
@media(max-width:576px){.level-row{display:block}.level-row span:last-child{text-align:left;display:block;margin-top:5px}}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Commission</p><h3>₹32,450</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month</p><h3>₹7,850</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending</p><h3 class="text-warning">₹1,250</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Paid</p><h3 class="text-success">₹31,200</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Note:</b> Startup package level commission is calculated from package purchases made by your downline members as per eligible level percentage.
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-4">
        <div class="level-box">
          <h4 class="fw-bold mb-3"><i class="fa fa-layer-group"></i> Level Wise Summary</h4>
          <div class="level-row"><span>Level 1</span><span>₹12,500</span></div>
          <div class="level-row"><span>Level 2</span><span>₹8,700</span></div>
          <div class="level-row"><span>Level 3</span><span>₹5,400</span></div>
          <div class="level-row"><span>Level 4</span><span>₹3,100</span></div>
          <div class="level-row"><span>Level 5</span><span>₹2,750</span></div>
          <div class="mt-4">
            <button class="btn btn-gold"><i class="fa fa-download"></i> Export Report</button>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card-box">
          <h5 class="fw-bold mb-3">Search Commission</h5>
          <form onsubmit="filterTable(event)">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" class="form-control" id="fromDate">
              </div>
              <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" class="form-control" id="toDate">
              </div>
              <div class="col-md-4">
                <label class="form-label">Level</label>
                <select class="form-select" id="levelFilter">
                  <option value="">All Levels</option>
                  <option>Level 1</option>
                  <option>Level 2</option>
                  <option>Level 3</option>
                  <option>Level 4</option>
                  <option>Level 5</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Status</label>
                <select class="form-select" id="statusFilter">
                  <option value="">All Status</option>
                  <option>Paid</option>
                  <option>Pending</option>
                  <option>Hold</option>
                </select>
              </div>
              <div class="col-md-8">
                <label class="form-label">Search Member</label>
                <input type="text" class="form-control" id="memberSearch" placeholder="Search by member name or ID">
              </div>
              <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
                <button type="reset" class="btn btn-secondary rounded-pill px-4" onclick="resetFilter()">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">Startup Package Level Commission List</h5>
        <div class="search-chip"><b>Eligible Package:</b> Startup Package</div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="commissionTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Member ID</th>
              <th>Member Name</th>
              <th>Package</th>
              <th>Package Amount</th>
              <th>Level</th>
              <th>Commission %</th>
              <th>Commission Amount</th>
              <th>Status</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td><td>29 Jun 2026</td><td>ARM1045</td><td>Rahul Sharma</td><td>Startup Package</td><td>₹5,000</td><td><span class="badge badge-level">Level 1</span></td><td>10%</td><td class="fw-bold text-success">₹500</td><td><span class="badge badge-paid">Paid</span></td><td>Credited to wallet</td>
            </tr>
            <tr>
              <td>2</td><td>28 Jun 2026</td><td>ARM1082</td><td>Priya Singh</td><td>Startup Package</td><td>₹10,000</td><td><span class="badge badge-level">Level 2</span></td><td>5%</td><td class="fw-bold text-success">₹500</td><td><span class="badge badge-paid">Paid</span></td><td>Credited to wallet</td>
            </tr>
            <tr>
              <td>3</td><td>27 Jun 2026</td><td>ARM1120</td><td>Amit Das</td><td>Startup Package</td><td>₹7,500</td><td><span class="badge badge-level">Level 3</span></td><td>3%</td><td class="fw-bold text-warning">₹225</td><td><span class="badge badge-pending">Pending</span></td><td>Under process</td>
            </tr>
            <tr>
              <td>4</td><td>25 Jun 2026</td><td>ARM1176</td><td>Neha Roy</td><td>Startup Package</td><td>₹15,000</td><td><span class="badge badge-level">Level 1</span></td><td>10%</td><td class="fw-bold text-success">₹1,500</td><td><span class="badge badge-paid">Paid</span></td><td>Credited to wallet</td>
            </tr>
            <tr>
              <td>5</td><td>23 Jun 2026</td><td>ARM1201</td><td>Sourav Paul</td><td>Startup Package</td><td>₹5,000</td><td><span class="badge badge-level">Level 4</span></td><td>2%</td><td class="fw-bold text-danger">₹100</td><td><span class="badge badge-hold">Hold</span></td><td>KYC pending</td>
            </tr>
            <tr>
              <td>6</td><td>21 Jun 2026</td><td>ARM1225</td><td>Mina Gupta</td><td>Startup Package</td><td>₹20,000</td><td><span class="badge badge-level">Level 5</span></td><td>1%</td><td class="fw-bold text-success">₹200</td><td><span class="badge badge-paid">Paid</span></td><td>Credited to wallet</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
