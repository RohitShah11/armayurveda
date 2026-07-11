@extends('layouts.app')

@section('title', 'Repurchase Order Report')
@section('page-title', 'Repurchase Order Report')

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
.badge-paid{background:#dff7e8;color:#198754}
.badge-pending{background:#fff3cd;color:#856404}
.badge-cancel{background:#fde2e2;color:#dc3545}
.product-img{width:52px;height:52px;border-radius:10px;object-fit:cover}
.info-row{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0}
.timeline{list-style:none;padding:0;margin:0}
.timeline li{padding:8px 0;font-weight:600}
.timeline i{color:#198754;margin-right:8px}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Orders</p><h3>12</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Order Amount</p><h3>₹42,850</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Delivered Orders</p><h3 class="text-success">8</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Discount</p><h3 class="text-danger">₹4,250</h3></div></div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Order Report</h5>

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
            <label class="form-label">Order Status</label>
            <select class="form-select" id="statusFilter">
              <option value="">All Status</option>
              <option value="Pending">Pending</option>
              <option value="Processing">Processing</option>
              <option value="Shipped">Shipped</option>
              <option value="Delivered">Delivered</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Payment Status</label>
            <select class="form-select" id="paymentFilter">
              <option value="">All Payment</option>
              <option value="Paid">Paid</option>
              <option value="Pending">Pending</option>
              <option value="Failed">Failed</option>
            </select>
          </div>

          <div class="col-lg-4 col-md-6">
            <label class="form-label">Search</label>
            <input type="text" class="form-control" id="searchBox" placeholder="Order ID / Invoice / Tracking">
          </div>

          <div class="col-lg-8 d-flex gap-2 flex-wrap">
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
        <h5 class="fw-bold mb-2">Repurchase Order List</h5>
        <small id="resultCount" class="text-muted">Showing 5 orders</small>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="orderTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Order ID</th>
              <th>Invoice</th>
              <th>Order Date</th>
              <th>Total Items</th>
              <th>Total Qty</th>
              <th>Order Amount</th>
              <th>Discount</th>
              <th>Payable</th>
              <th>Payment</th>
              <th>Order Status</th>
              <th>Invoice</th>
              <th>Details</th>
            </tr>
          </thead>

          <tbody>
            <tr data-date="2026-06-28" data-status="Delivered" data-payment="Paid">
              <td>1</td><td>ORD10001</td><td>INV50001</td><td>28 Jun 2026</td>
              <td>5</td><td>12</td><td>₹4,950</td><td>₹750</td><td>₹4,300</td>
              <td><span class="badge badge-paid">Paid</span></td>
              <td><span class="badge bg-success">Delivered</span></td>
              <td><a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Download</a></td>
              <td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal">View</button></td>
            </tr>

            <tr data-date="2026-06-26" data-status="Shipped" data-payment="Paid">
              <td>2</td><td>ORD10002</td><td>INV50002</td><td>26 Jun 2026</td>
              <td>3</td><td>6</td><td>₹2,850</td><td>₹300</td><td>₹2,550</td>
              <td><span class="badge badge-paid">Paid</span></td>
              <td><span class="badge bg-primary">Shipped</span></td>
              <td><a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Download</a></td>
              <td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal">View</button></td>
            </tr>

            <tr data-date="2026-06-24" data-status="Processing" data-payment="Paid">
              <td>3</td><td>ORD10003</td><td>INV50003</td><td>24 Jun 2026</td>
              <td>2</td><td>4</td><td>₹1,980</td><td>₹180</td><td>₹1,800</td>
              <td><span class="badge badge-paid">Paid</span></td>
              <td><span class="badge bg-warning text-dark">Processing</span></td>
              <td><a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Download</a></td>
              <td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal">View</button></td>
            </tr>

            <tr data-date="2026-06-22" data-status="Pending" data-payment="Pending">
              <td>4</td><td>ORD10004</td><td>INV50004</td><td>22 Jun 2026</td>
              <td>4</td><td>8</td><td>₹3,200</td><td>₹250</td><td>₹2,950</td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td><span class="badge badge-pending">Pending</span></td>
              <td><a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Download</a></td>
              <td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal">View</button></td>
            </tr>

            <tr data-date="2026-06-20" data-status="Cancelled" data-payment="Failed">
              <td>5</td><td>ORD10005</td><td>INV50005</td><td>20 Jun 2026</td>
              <td>1</td><td>2</td><td>₹900</td><td>₹50</td><td>₹850</td>
              <td><span class="badge badge-cancel">Failed</span></td>
              <td><span class="badge bg-danger">Cancelled</span></td>
              <td><a href="{{ url('#') }}" class="btn btn-sm btn-outline-danger">Download</a></td>
              <td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal">View</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Order Details - ORD10001</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="card-box">
              <h6 class="fw-bold mb-3">Order Information</h6>
              <div class="info-row"><b>Order ID</b><span>ORD10001</span></div>
              <div class="info-row"><b>Invoice</b><span>INV50001</span></div>
              <div class="info-row"><b>Order Date</b><span>28 Jun 2026</span></div>
              <div class="info-row"><b>Payment Mode</b><span>Wallet</span></div>
              <div class="info-row"><b>Payment Status</b><span>Paid</span></div>
              <div class="info-row"><b>Order Status</b><span>Delivered</span></div>
              <div class="info-row"><b>Courier</b><span>Delhivery</span></div>
              <div class="info-row"><b>Tracking No</b><span>TRK789654123</span></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card-box">
              <h6 class="fw-bold mb-3">Delivery Address</h6>
              <p><b>Name:</b> Member Name</p>
              <p><b>Mobile:</b> 9876543210</p>
              <p><b>Address:</b> Ashoknagar, North 24 Parganas</p>
              <p><b>State:</b> West Bengal</p>
              <p><b>PIN:</b> 743222</p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card-box">
              <h6 class="fw-bold mb-3">Order Timeline</h6>
              <ul class="timeline">
                <li><i class="fa fa-check-circle"></i> Order Placed</li>
                <li><i class="fa fa-check-circle"></i> Payment Received</li>
                <li><i class="fa fa-check-circle"></i> Packed</li>
                <li><i class="fa fa-check-circle"></i> Shipped</li>
                <li><i class="fa fa-check-circle"></i> Out for Delivery</li>
                <li><i class="fa fa-check-circle"></i> Delivered</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="card-box mt-4">
          <h6 class="fw-bold mb-3">Purchased Products</h6>
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Product Name</th>
                  <th>Qty</th>
                  <th>MRP</th>
                  <th>Discount</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><img class="product-img" src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=200&q=80"></td>
                  <td>Ashwagandha Capsules</td><td>2</td><td>₹750</td><td>₹100</td><td>₹1,400</td>
                </tr>
                <tr>
                  <td><img class="product-img" src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?auto=format&fit=crop&w=200&q=80"></td>
                  <td>Aloe Vera Juice</td><td>1</td><td>₹650</td><td>₹50</td><td>₹600</td>
                </tr>
                <tr>
                  <td><img class="product-img" src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=200&q=80"></td>
                  <td>Herbal Face Wash</td><td>3</td><td>₹250</td><td>₹75</td><td>₹675</td>
                </tr>
                <tr>
                  <td><img class="product-img" src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=200&q=80"></td>
                  <td>Natural Honey</td><td>2</td><td>₹450</td><td>₹50</td><td>₹850</td>
                </tr>
                <tr>
                  <td><img class="product-img" src="https://images.unsplash.com/photo-1600428877878-1a0fd85beda0?auto=format&fit=crop&w=200&q=80"></td>
                  <td>Immunity Booster Syrup</td><td>4</td><td>₹350</td><td>₹100</td><td>₹1,300</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="row g-4 mt-1">
          <div class="col-lg-7"></div>
          <div class="col-lg-5">
            <div class="card-box">
              <h6 class="fw-bold mb-3">Order Summary</h6>
              <div class="info-row"><b>Subtotal</b><span>₹4,950</span></div>
              <div class="info-row"><b>Discount</b><span>₹750</span></div>
              <div class="info-row"><b>Shipping</b><span>₹100</span></div>
              <div class="info-row"><b>Total Payable</b><span class="fw-bold text-success">₹4,300</span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <a href="{{ url('#') }}" class="btn btn-main">Download Invoice</a>
        <a href="{{ url('#') }}" class="btn btn-gold">Track Order</a>
        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
@endsection
