@extends('layouts.app')

@section('title', 'Zenith Package')
@section('page-title', 'Zenith Package')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.package-card{background:#fff;border-radius:22px;overflow:hidden;box-shadow:0 8px 25px rgba(0,0,0,.08);height:100%;border:1px solid #eee}
.package-card img{width:100%;height:220px;object-fit:cover}
.package-
.package-body h5{color:var(--primary);font-weight:900}
.price{font-size:26px;font-weight:900;color:var(--primary)}
.mrp{text-decoration:line-through;color:#777}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.badge-zenith{background:#e8f5ff;color:#0d6efd}
.alert-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.lock-box{background:#fff3cd;border-left:5px solid #ffc107;border-radius:14px;padding:25px}
.table thead th{background:var(--primary);color:#fff}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="card-box">
          <h6>Main Wallet</h6>
          <h3 class="fw-bold text-success">₹15,000</h3>
          <small>Wallet balance available</small>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box">
          <h6>Basic Package</h6>
          <h3 class="fw-bold text-success">Active</h3>
          <small>Required for Zenith purchase</small>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box">
          <h6>Zenith Package</h6>
          <h3 class="fw-bold" id="zenithStatus">Not Purchased</h3>
          <small id="zenithNote">Choose any one product</small>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box">
          <h6>Package Price</h6>
          <h3 class="fw-bold text-primary">₹10,500</h3>
          <small>BV: 5000</small>
        </div>
      </div>
    </div>

    <div class="alert-note mb-4">
      <b>Important:</b> Zenith Package will be visible only after Basic Package purchase. User must choose any one Zenith product. Products will be managed from admin panel.
    </div>

    <!-- LOCK MESSAGE: show this if basic package not purchased -->
    <div class="lock-box mb-4 d-none" id="lockMessage">
      <h5 class="fw-bold"><i class="fa fa-lock"></i> Zenith Package Locked</h5>
      <p class="mb-3">Please purchase Basic Package first. After Basic Package activation, Zenith Package will be available.</p>
      <a href="purchase-package.html" class="btn btn-main">Purchase Basic Package</a>
    </div>

    <!-- ZENITH PRODUCTS -->
    <section id="zenithProducts">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div>
          <h4 class="fw-bold">Choose Zenith Package Product</h4>
          <p class="mb-0 text-muted">Select any one product to activate Zenith Package.</p>
        </div>
        <span class="badge badge-zenith p-2">Upgrade Package</span>
      </div>

      <div class="row g-4 mb-5">

        <div class="col-lg-4 col-md-6">
          <div class="package-card">
            <img src="https://images.unsplash.com/photo-1600428877878-1a0fd85beda0?auto=format&fit=crop&w=700&q=80">
            <div class="package-body">
              <span class="badge badge-zenith mb-2">Zenith Product</span>
              <h5>Zenith Immunity Combo</h5>
              <p>Premium immunity and daily wellness product package.</p>
              <p><span class="mrp">MRP ₹12,500</span></p>
              <div class="price">₹10,500</div>
              <small>BV: 5000</small>
              <button class="btn btn-main w-100 mt-3" onclick="openConfirm('Zenith Immunity Combo','10500')">Purchase Now</button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="package-card">
            <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=700&q=80">
            <div class="package-body">
              <span class="badge badge-zenith mb-2">Zenith Product</span>
              <h5>Zenith Personal Care Combo</h5>
              <p>Premium skin, hair and personal care package.</p>
              <p><span class="mrp">MRP ₹12,500</span></p>
              <div class="price">₹10,500</div>
              <small>BV: 5000</small>
              <button class="btn btn-main w-100 mt-3" onclick="openConfirm('Zenith Personal Care Combo','10500')">Purchase Now</button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="package-card">
            <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=700&q=80">
            <div class="package-body">
              <span class="badge badge-zenith mb-2">Zenith Product</span>
              <h5>Zenith Honey Wellness Pack</h5>
              <p>Premium honey and health support combo package.</p>
              <p><span class="mrp">MRP ₹12,500</span></p>
              <div class="price">₹10,500</div>
              <small>BV: 5000</small>
              <button class="btn btn-main w-100 mt-3" onclick="openConfirm('Zenith Honey Wellness Pack','10500')">Purchase Now</button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="package-card">
            <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?auto=format&fit=crop&w=700&q=80">
            <div class="package-body">
              <span class="badge badge-zenith mb-2">Zenith Product</span>
              <h5>Zenith Juice Combo</h5>
              <p>Aloe vera, amla and herbal juice package.</p>
              <p><span class="mrp">MRP ₹12,500</span></p>
              <div class="price">₹10,500</div>
              <small>BV: 5000</small>
              <button class="btn btn-main w-100 mt-3" onclick="openConfirm('Zenith Juice Combo','10500')">Purchase Now</button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="package-card">
            <img src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=700&q=80">
            <div class="package-body">
              <span class="badge badge-zenith mb-2">Zenith Product</span>
              <h5>Zenith Daily Wellness Pack</h5>
              <p>Herbal tea, nutrition and daily wellness package.</p>
              <p><span class="mrp">MRP ₹12,500</span></p>
              <div class="price">₹10,500</div>
              <small>BV: 5000</small>
              <button class="btn btn-main w-100 mt-3" onclick="openConfirm('Zenith Daily Wellness Pack','10500')">Purchase Now</button>
            </div>
          </div>
        </div>

      </div>
    </section>

    <div class="card-box">
      <h5 class="fw-bold mb-3">Zenith Package Purchase History</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Date</th>
              <th>Package</th>
              <th>Selected Product</th>
              <th>Amount</th>
              <th>BV</th>
              <th>Status</th>
              <th>Invoice</th>
            </tr>
          </thead>
          <tbody id="historyTable">
            <tr>
              <td colspan="7" class="text-center text-muted">No Zenith Package purchased yet.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Confirm Zenith Package Purchase</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><b>Package:</b> Zenith Package</p>
        <p><b>Selected Product:</b> <span id="modalProduct"></span></p>
        <p><b>Amount:</b> ₹<span id="modalAmount"></span></p>
        <p><b>BV:</b> 5000</p>
        <p><b>Wallet Balance:</b> ₹15,000</p>
        <div class="alert alert-warning mb-0">
          Once Zenith Package is purchased, this package will not be available again.
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-main" onclick="purchaseZenith()">Purchase Zenith</button>
      </div>
    </div>
  </div>
@endsection
