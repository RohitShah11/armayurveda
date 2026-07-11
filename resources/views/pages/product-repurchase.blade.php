@extends('layouts.app')

@section('title', 'Product Repurchase Bonus')
@section('page-title', 'Product Repurchase Bonus')

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
.level-item{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,.2);padding:12px 0;gap:12px}
.level-item span:last-child{font-weight:800;color:#ffe28a}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-paid{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-hold{background:#fde2e2;color:#dc3545}
@media(max-width:991px){}
@media(max-width:576px){.page-.card-box,.level-box{padding:18px}.level-item{display:block}.level-item span:last-child{display:block;margin-top:4px}}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Repurchase BV</p><h3>48,500</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Bonus</p><h3>₹12,250</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month Income</p><h3 class="text-success">₹4,750</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending Income</p><h3 class="text-warning">₹1,250</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Note:</b> Product Repurchase Bonus is generated level-wise from team product repurchase. Income percentage and eligibility can be changed as per company plan.
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-4">
        <div class="level-box">
          <h5 class="fw-bold mb-3"><i class="fa fa-layer-group"></i> Level Wise Summary</h5>
          <div class="level-item"><span>Level 1</span><span>₹4,500</span></div>
          <div class="level-item"><span>Level 2</span><span>₹3,250</span></div>
          <div class="level-item"><span>Level 3</span><span>₹2,100</span></div>
          <div class="level-item"><span>Level 4</span><span>₹1,400</span></div>
          <div class="level-item"><span>Level 5</span><span>₹1,000</span></div>
          <div class="mt-4">
            <a href="{{ url('#') }}" class="btn btn-gold"><i class="fa fa-download"></i> Export Report</a>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card-box">
          <h5 class="fw-bold mb-3">Search Repurchase Income</h5>
          <form onsubmit="filterReport(event)">
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
                <label class="form-label">Member Search</label>
                <input type="text" class="form-control" id="memberSearch" placeholder="Search by member name or ID">
              </div>
              <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
                <button type="reset" class="btn btn-secondary rounded-pill px-4" onclick="resetReport()">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">Level Wise Repurchase Income List</h5>
        <span class="fw-bold text-success">Total: ₹12,250</span>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Order ID</th>
              <th>From Member</th>
              <th>Member ID</th>
              <th>Level</th>
              <th>Product BV</th>
              <th>Bonus %</th>
              <th>Income</th>
              <th>Status</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody id="reportTable">
            <tr>
              <td>1</td><td>30 Jun 2026</td><td>ORD10089</td><td>Rahul Sharma</td><td>ARM1021</td><td>Level 1</td><td>5,000</td><td>5%</td><td>₹250</td><td><span class="badge badge-paid">Paid</span></td><td>Repurchase bonus credited</td>
            </tr>
            <tr>
              <td>2</td><td>29 Jun 2026</td><td>ORD10072</td><td>Priya Sen</td><td>ARM1088</td><td>Level 2</td><td>8,000</td><td>4%</td><td>₹320</td><td><span class="badge badge-paid">Paid</span></td><td>Level 2 income</td>
            </tr>
            <tr>
              <td>3</td><td>28 Jun 2026</td><td>ORD10061</td><td>Amit Roy</td><td>ARM1134</td><td>Level 3</td><td>10,000</td><td>3%</td><td>₹300</td><td><span class="badge badge-pending">Pending</span></td><td>Under calculation</td>
            </tr>
            <tr>
              <td>4</td><td>26 Jun 2026</td><td>ORD10045</td><td>Neha Das</td><td>ARM1190</td><td>Level 4</td><td>12,000</td><td>2%</td><td>₹240</td><td><span class="badge badge-paid">Paid</span></td><td>Paid in wallet</td>
            </tr>
            <tr>
              <td>5</td><td>24 Jun 2026</td><td>ORD10032</td><td>Suman Paul</td><td>ARM1235</td><td>Level 5</td><td>15,000</td><td>1%</td><td>₹150</td><td><span class="badge badge-hold">Hold</span></td><td>Eligibility pending</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
