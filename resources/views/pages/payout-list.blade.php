@extends('layouts.app')

@section('title', 'Payout List')
@section('page-title', 'Payout List')

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
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.badge-pending{background:#fff3cd;color:#856404}
.badge-approved{background:#dff7e8;color:#198754}
.badge-rejected{background:#fde2e2;color:#dc3545}
.badge-processing{background:#dbeafe;color:#0d6efd}
.action-btn{width:34px;height:34px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;text-decoration:none}
.search-box{background:var(--light);border-radius:18px;padding:18px}
.modal-header{background:var(--primary);color:#fff}
.detail-row{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0;gap:15px}
.detail-row span:last-child{font-weight:700;text-align:right}
@media(max-width:991px){}
@media(max-width:576px){.detail-row{display:block}.detail-row span:last-child{text-align:left;display:block;margin-top:4px}.page-}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Requests</p><h3>12</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending</p><h3 class="text-warning">₹2,000</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Approved</p><h3 class="text-success">₹18,000</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Rejected</p><h3 class="text-danger">₹1,000</h3></div></div>
    </div>

    <div class="info-note mb-4">
      <b>Note:</b> Here you can check all previous payout requests with status, payment date, transaction ID, and admin remark.
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3"><i class="fa fa-filter"></i> Filter Payout Requests</h5>
      <div class="search-box">
        <div class="row g-3">
          <div class="col-lg-3 col-md-6">
            <label class="form-label">From Date</label>
            <input type="date" class="form-control" id="fromDate">
          </div>
          <div class="col-lg-3 col-md-6">
            <label class="form-label">To Date</label>
            <input type="date" class="form-control" id="toDate">
          </div>
          <div class="col-lg-3 col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" id="statusFilter">
              <option value="">All Status</option>
              <option value="Pending">Pending</option>
              <option value="Processing">Processing</option>
              <option value="Approved">Approved</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-6">
            <label class="form-label">Search</label>
            <input type="text" class="form-control" id="searchInput" placeholder="Txn ID / mode">
          </div>
          <div class="col-12 d-flex gap-2 flex-wrap">
            <button class="btn btn-main" onclick="filterTable()"><i class="fa fa-search"></i> Search</button>
            <button class="btn btn-secondary rounded-pill px-4" onclick="resetFilter()"><i class="fa fa-rotate-left"></i> Reset</button>
            <button class="btn btn-gold ms-auto" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">Previous Payout Requests</h5>
        <a href="payout-request.html" class="btn btn-main btn-sm"><i class="fa fa-plus"></i> New Request</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="payoutListTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Request Date</th>
              <th>Amount</th>
              <th>Charge</th>
              <th>Net Payable</th>
              <th>Mode</th>
              <th>Status</th>
              <th>Payment Date</th>
              <th>Transaction ID</th>
              <th>Admin Remark</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr data-status="Pending" data-date="2026-06-28">
              <td>1</td>
              <td>28 Jun 2026</td>
              <td>₹2,000</td>
              <td>₹0</td>
              <td>₹2,000</td>
              <td>Bank Transfer</td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td>-</td>
              <td>-</td>
              <td>Under verification</td>
              <td><button class="btn btn-sm btn-outline-primary action-btn" onclick="viewDetails(this)"><i class="fa fa-eye"></i></button></td>
            </tr>
            <tr data-status="Approved" data-date="2026-06-25">
              <td>2</td>
              <td>25 Jun 2026</td>
              <td>₹5,000</td>
              <td>₹0</td>
              <td>₹5,000</td>
              <td>UPI</td>
              <td><span class="badge badge-approved">Approved</span></td>
              <td>26 Jun 2026</td>
              <td>UPI987654321</td>
              <td>Paid successfully</td>
              <td><button class="btn btn-sm btn-outline-primary action-btn" onclick="viewDetails(this)"><i class="fa fa-eye"></i></button></td>
            </tr>
            <tr data-status="Processing" data-date="2026-06-20">
              <td>3</td>
              <td>20 Jun 2026</td>
              <td>₹3,000</td>
              <td>₹50</td>
              <td>₹2,950</td>
              <td>Bank Transfer</td>
              <td><span class="badge badge-processing">Processing</span></td>
              <td>-</td>
              <td>-</td>
              <td>Payment initiated</td>
              <td><button class="btn btn-sm btn-outline-primary action-btn" onclick="viewDetails(this)"><i class="fa fa-eye"></i></button></td>
            </tr>
            <tr data-status="Rejected" data-date="2026-06-15">
              <td>4</td>
              <td>15 Jun 2026</td>
              <td>₹1,000</td>
              <td>₹0</td>
              <td>₹1,000</td>
              <td>UPI</td>
              <td><span class="badge badge-rejected">Rejected</span></td>
              <td>-</td>
              <td>-</td>
              <td>Bank/KYC details mismatch</td>
              <td><button class="btn btn-sm btn-outline-primary action-btn" onclick="viewDetails(this)"><i class="fa fa-eye"></i></button></td>
            </tr>
            <tr data-status="Approved" data-date="2026-06-10">
              <td>5</td>
              <td>10 Jun 2026</td>
              <td>₹8,000</td>
              <td>₹0</td>
              <td>₹8,000</td>
              <td>Bank Transfer</td>
              <td><span class="badge badge-approved">Approved</span></td>
              <td>11 Jun 2026</td>
              <td>NEFT123456789</td>
              <td>Paid to registered bank account</td>
              <td><button class="btn btn-sm btn-outline-primary action-btn" onclick="viewDetails(this)"><i class="fa fa-eye"></i></button></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
        <small class="text-muted" id="recordCount">Showing 5 records</small>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="{{ url('#') }}">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="{{ url('#') }}">1</a></li>
            <li class="page-item"><a class="page-link" href="{{ url('#') }}">2</a></li>
            <li class="page-item"><a class="page-link" href="{{ url('#') }}">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="detailsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-circle-info"></i> Payout Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailsBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-main" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
      </div>
    </div>
  </div>
@endsection
