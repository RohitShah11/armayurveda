@extends('layouts.app')

@section('title', 'Package Purchase Report')
@section('page-title', 'Package Purchase Report')

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
.product-img{width:48px;height:48px;border-radius:10px;object-fit:cover}
.badge-basic{background:#e8f5ff;color:#0d6efd}
.badge-zenith{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-failed{background:#fde2e2;color:#dc3545}
.info-row{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total Package Purchase</p>
          <h3>8</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Basic Package</p>
          <h3 class="text-primary">5</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Zenith Package</p>
          <h3 class="text-success">3</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total Purchase Amount</p>
          <h3>₹41,495</h3>
        </div>
      </div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Package Report</h5>

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
            <label class="form-label">Package Type</label>
            <select class="form-select" id="packageFilter">
              <option value="">All Package</option>
              <option value="Basic">Basic Package</option>
              <option value="Zenith">Zenith Package</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Payment Status</label>
            <select class="form-select" id="statusFilter">
              <option value="">All Status</option>
              <option value="Success">Success</option>
              <option value="Pending">Pending</option>
              <option value="Failed">Failed</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Payment Mode</label>
            <select class="form-select" id="modeFilter">
              <option value="">All Mode</option>
              <option value="Wallet">Wallet</option>
              <option value="UPI">UPI</option>
              <option value="Bank">Bank</option>
              <option value="QR Payment">QR Payment</option>
            </select>
          </div>

          <div class="col-lg-4 col-md-6">
            <label class="form-label">Search</label>
            <input type="text" class="form-control" id="searchBox" placeholder="Invoice / Product / Txn ID">
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
        <h5 class="fw-bold mb-2">Package Purchase List</h5>
        <small id="resultCount" class="text-muted">Showing 8 package records</small>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="packageTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Invoice No</th>
              <th>Date</th>
              <th>Package</th>
              <th>Product</th>
              <th>Image</th>
              <th>Amount</th>
              <th>Payment Mode</th>
              <th>Wallet Used</th>
              <th>Payment Status</th>
              <th>Activation</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <tr data-date="2026-06-28" data-package="Zenith" data-status="Success" data-mode="Wallet">
              <td>1</td>
              <td>INV10001</td>
              <td>28 Jun 2026</td>
              <td><span class="badge badge-zenith">Zenith Package</span></td>
              <td>Zenith Immunity Combo</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1600428877878-1a0fd85beda0?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹10,500</td>
              <td>Wallet</td>
              <td>₹10,500</td>
              <td><span class="badge bg-success">Success</span></td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10001','Zenith Package','Zenith Immunity Combo','₹10,500','Wallet','Success','Active')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-26" data-package="Basic" data-status="Success" data-mode="Wallet">
              <td>2</td>
              <td>INV10002</td>
              <td>26 Jun 2026</td>
              <td><span class="badge badge-basic">Basic Package</span></td>
              <td>Ashwagandha Wellness Pack</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹1,999</td>
              <td>Wallet</td>
              <td>₹1,999</td>
              <td><span class="badge bg-success">Success</span></td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10002','Basic Package','Ashwagandha Wellness Pack','₹1,999','Wallet','Success','Active')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-24" data-package="Basic" data-status="Success" data-mode="UPI">
              <td>3</td>
              <td>INV10003</td>
              <td>24 Jun 2026</td>
              <td><span class="badge badge-basic">Basic Package</span></td>
              <td>Aloe Vera Juice Pack</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹1,999</td>
              <td>UPI</td>
              <td>₹0</td>
              <td><span class="badge bg-success">Success</span></td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10003','Basic Package','Aloe Vera Juice Pack','₹1,999','UPI','Success','Active')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-22" data-package="Zenith" data-status="Pending" data-mode="QR Payment">
              <td>4</td>
              <td>INV10004</td>
              <td>22 Jun 2026</td>
              <td><span class="badge badge-zenith">Zenith Package</span></td>
              <td>Zenith Personal Care Combo</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹10,500</td>
              <td>QR Payment</td>
              <td>₹0</td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10004','Zenith Package','Zenith Personal Care Combo','₹10,500','QR Payment','Pending','Pending')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-20" data-package="Basic" data-status="Success" data-mode="Bank">
              <td>5</td>
              <td>INV10005</td>
              <td>20 Jun 2026</td>
              <td><span class="badge badge-basic">Basic Package</span></td>
              <td>Tulsi Drops Combo</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹1,999</td>
              <td>Bank</td>
              <td>₹0</td>
              <td><span class="badge bg-success">Success</span></td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10005','Basic Package','Tulsi Drops Combo','₹1,999','Bank','Success','Active')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-18" data-package="Basic" data-status="Failed" data-mode="UPI">
              <td>6</td>
              <td>INV10006</td>
              <td>18 Jun 2026</td>
              <td><span class="badge badge-basic">Basic Package</span></td>
              <td>Herbal Personal Care Pack</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹1,999</td>
              <td>UPI</td>
              <td>₹0</td>
              <td><span class="badge badge-failed">Failed</span></td>
              <td><span class="badge badge-failed">Failed</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10006','Basic Package','Herbal Personal Care Pack','₹1,999','UPI','Failed','Failed')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-15" data-package="Zenith" data-status="Success" data-mode="Wallet">
              <td>7</td>
              <td>INV10007</td>
              <td>15 Jun 2026</td>
              <td><span class="badge badge-zenith">Zenith Package</span></td>
              <td>Zenith Honey Wellness Pack</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹10,500</td>
              <td>Wallet</td>
              <td>₹10,500</td>
              <td><span class="badge bg-success">Success</span></td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10007','Zenith Package','Zenith Honey Wellness Pack','₹10,500','Wallet','Success','Active')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>

            <tr data-date="2026-06-12" data-package="Basic" data-status="Success" data-mode="Wallet">
              <td>8</td>
              <td>INV10008</td>
              <td>12 Jun 2026</td>
              <td><span class="badge badge-basic">Basic Package</span></td>
              <td>Daily Wellness Tea Pack</td>
              <td><img class="product-img" src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=300&q=80"></td>
              <td>₹1,999</td>
              <td>Wallet</td>
              <td>₹1,999</td>
              <td><span class="badge bg-success">Success</span></td>
              <td><span class="badge bg-success">Active</span></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('INV10008','Basic Package','Daily Wellness Tea Pack','₹1,999','Wallet','Success','Active')">View</button>
                <a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Invoice</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
        <small>Showing package purchase records</small>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link">Previous</a></li>
            <li class="page-item active"><a class="page-link">1</a></li>
            <li class="page-item"><a class="page-link">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="detailsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Package Purchase Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-4">
          <div class="col-md-5 text-center">
            <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=500&q=80" class="img-fluid rounded-4">
          </div>

          <div class="col-md-7">
            <div class="info-row"><b>Invoice No</b><span id="mInvoice"></span></div>
            <div class="info-row"><b>Package</b><span id="mPackage"></span></div>
            <div class="info-row"><b>Selected Product</b><span id="mProduct"></span></div>
            <div class="info-row"><b>Amount</b><span id="mAmount"></span></div>
            <div class="info-row"><b>Payment Mode</b><span id="mMode"></span></div>
            <div class="info-row"><b>Payment Status</b><span id="mStatus"></span></div>
            <div class="info-row"><b>Activation Status</b><span id="mActivation"></span></div>
            <div class="info-row"><b>Purchase Date</b><span>28 Jun 2026</span></div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
        <a href="{{ url('#') }}" class="btn btn-main">Download Invoice</a>
      </div>
    </div>
  </div>
@endsection
