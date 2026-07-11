@extends('layouts.app')

@section('title', 'Recharge Report')
@section('page-title', 'Recharge Report')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:46px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-mobile{background:#e8f5ff;color:#0d6efd}
.badge-dth{background:#fff3cd;color:#856404}
.badge-success-soft{background:#dff7e8;color:#198754}
.badge-pending-soft{background:#fff3cd;color:#856404}
.badge-failed-soft{background:#fde2e2;color:#dc3545}
.info-row{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Recharge</p><h3>18</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Amount</p><h3>₹8,420</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Successful</p><h3 class="text-success">15</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Failed / Pending</p><h3 class="text-danger">3</h3></div></div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Recharge Report</h5>

      <form onsubmit="filterReport(event)">
        <div class="row g-3 align-items-end">
          <div class="col-lg-3 col-md-6">
            <label class="form-label">From Date</label>
            <input type="date" class="form-control" id="fromDate">
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">To Date</label>
            <input type="date" class="form-control" id="toDate">
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Recharge Type</label>
            <select class="form-select" id="typeFilter">
              <option value="">All Type</option>
              <option value="Mobile">Mobile Recharge</option>
              <option value="DTH">DTH Recharge</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" id="statusFilter">
              <option value="">All Status</option>
              <option value="Success">Success</option>
              <option value="Pending">Pending</option>
              <option value="Failed">Failed</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Operator</label>
            <select class="form-select" id="operatorFilter">
              <option value="">All Operators</option>
              <option value="Jio">Jio</option>
              <option value="Airtel">Airtel</option>
              <option value="VI">VI</option>
              <option value="BSNL">BSNL</option>
              <option value="Tata Play">Tata Play</option>
              <option value="Dish TV">Dish TV</option>
            </select>
          </div>

          <div class="col-lg-4 col-md-6">
            <label class="form-label">Search</label>
            <input type="text" class="form-control" id="searchBox" placeholder="Txn ID / Number / Operator">
          </div>

          <div class="col-lg-5 d-flex gap-2 flex-wrap">
            <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
            <button type="button" class="btn btn-secondary rounded-pill px-4" onclick="resetFilter()">Reset</button>
            <button type="button" class="btn btn-gold"><i class="fa fa-file-excel"></i> Export Excel</button>
            <button type="button" class="btn btn-outline-danger rounded-pill px-4"><i class="fa fa-file-pdf"></i> Export PDF</button>
          </div>
        </div>
      </form>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h5 class="fw-bold mb-2">Recharge Transaction List</h5>
        <small id="resultCount" class="text-muted">Showing 8 recharge records</small>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="rechargeTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Txn ID</th>
              <th>Type</th>
              <th>Mobile / Customer ID</th>
              <th>Operator</th>
              <th>Amount</th>
              <th>Cashback</th>
              <th>Wallet Debit</th>
              <th>Status</th>
              <th>API Ref No</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <tr data-date="2026-06-28" data-type="Mobile" data-status="Success" data-operator="Jio">
              <td>1</td><td>28 Jun 2026</td><td>RCH10001</td>
              <td><span class="badge badge-mobile">Mobile</span></td>
              <td>9876543210</td><td>Jio</td><td>₹299</td><td>₹6</td><td>₹299</td>
              <td><span class="badge badge-success-soft">Success</span></td><td>API789654</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10001','Mobile','9876543210','Jio','₹299','₹6','Success','API789654')">View</button></td>
            </tr>

            <tr data-date="2026-06-27" data-type="Mobile" data-status="Success" data-operator="Airtel">
              <td>2</td><td>27 Jun 2026</td><td>RCH10002</td>
              <td><span class="badge badge-mobile">Mobile</span></td>
              <td>9000000000</td><td>Airtel</td><td>₹199</td><td>₹4</td><td>₹199</td>
              <td><span class="badge badge-success-soft">Success</span></td><td>API123987</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10002','Mobile','9000000000','Airtel','₹199','₹4','Success','API123987')">View</button></td>
            </tr>

            <tr data-date="2026-06-26" data-type="DTH" data-status="Pending" data-operator="Tata Play">
              <td>3</td><td>26 Jun 2026</td><td>RCH10003</td>
              <td><span class="badge badge-dth">DTH</span></td>
              <td>TP12345678</td><td>Tata Play</td><td>₹500</td><td>₹10</td><td>₹500</td>
              <td><span class="badge badge-pending-soft">Pending</span></td><td>API456123</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10003','DTH','TP12345678','Tata Play','₹500','₹10','Pending','API456123')">View</button></td>
            </tr>

            <tr data-date="2026-06-25" data-type="Mobile" data-status="Failed" data-operator="VI">
              <td>4</td><td>25 Jun 2026</td><td>RCH10004</td>
              <td><span class="badge badge-mobile">Mobile</span></td>
              <td>9123456789</td><td>VI</td><td>₹349</td><td>₹0</td><td>₹349</td>
              <td><span class="badge badge-failed-soft">Failed</span></td><td>API000111</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10004','Mobile','9123456789','VI','₹349','₹0','Failed','API000111')">View</button></td>
            </tr>

            <tr data-date="2026-06-24" data-type="DTH" data-status="Success" data-operator="Dish TV">
              <td>5</td><td>24 Jun 2026</td><td>RCH10005</td>
              <td><span class="badge badge-dth">DTH</span></td>
              <td>DISH998877</td><td>Dish TV</td><td>₹700</td><td>₹14</td><td>₹700</td>
              <td><span class="badge badge-success-soft">Success</span></td><td>API333222</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10005','DTH','DISH998877','Dish TV','₹700','₹14','Success','API333222')">View</button></td>
            </tr>

            <tr data-date="2026-06-23" data-type="Mobile" data-status="Success" data-operator="BSNL">
              <td>6</td><td>23 Jun 2026</td><td>RCH10006</td>
              <td><span class="badge badge-mobile">Mobile</span></td>
              <td>9234567890</td><td>BSNL</td><td>₹397</td><td>₹8</td><td>₹397</td>
              <td><span class="badge badge-success-soft">Success</span></td><td>API665544</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10006','Mobile','9234567890','BSNL','₹397','₹8','Success','API665544')">View</button></td>
            </tr>

            <tr data-date="2026-06-22" data-type="Mobile" data-status="Success" data-operator="Jio">
              <td>7</td><td>22 Jun 2026</td><td>RCH10007</td>
              <td><span class="badge badge-mobile">Mobile</span></td>
              <td>9345678901</td><td>Jio</td><td>₹666</td><td>₹13</td><td>₹666</td>
              <td><span class="badge badge-success-soft">Success</span></td><td>API777888</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10007','Mobile','9345678901','Jio','₹666','₹13','Success','API777888')">View</button></td>
            </tr>

            <tr data-date="2026-06-21" data-type="DTH" data-status="Success" data-operator="Tata Play">
              <td>8</td><td>21 Jun 2026</td><td>RCH10008</td>
              <td><span class="badge badge-dth">DTH</span></td>
              <td>TP87654321</td><td>Tata Play</td><td>₹1,000</td><td>₹20</td><td>₹1,000</td>
              <td><span class="badge badge-success-soft">Success</span></td><td>API999000</td>
              <td><button class="btn btn-sm btn-outline-primary" onclick="viewDetails('RCH10008','DTH','TP87654321','Tata Play','₹1,000','₹20','Success','API999000')">View</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="detailsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Recharge Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="info-row"><b>Txn ID</b><span id="mTxn"></span></div>
        <div class="info-row"><b>Recharge Type</b><span id="mType"></span></div>
        <div class="info-row"><b>Number / Customer ID</b><span id="mNumber"></span></div>
        <div class="info-row"><b>Operator</b><span id="mOperator"></span></div>
        <div class="info-row"><b>Amount</b><span id="mAmount"></span></div>
        <div class="info-row"><b>Cashback</b><span id="mCashback"></span></div>
        <div class="info-row"><b>Status</b><span id="mStatus"></span></div>
        <div class="info-row"><b>API Ref No</b><span id="mApi"></span></div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
        <a href="{{ url('#') }}" class="btn btn-main">Download Receipt</a>
      </div>
    </div>
  </div>
@endsection
