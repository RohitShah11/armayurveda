@extends('layouts.app')

@section('title', 'Zenith Team Package Commission')
@section('page-title', 'Zenith Team Package Commission')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}.stat-card{border-left:5px solid var(--primary)}.stat-card h3{font-weight:900;color:var(--primary)}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}.btn-main:hover{background:var(--dark);color:#fff}.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.form-control,.form-select{height:48px;border-radius:12px}.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.hero-box{background:linear-gradient(135deg,#06163b,#0d2d70);color:#fff;border-radius:20px;padding:30px;position:relative;overflow:hidden}.hero-box:after{content:"";position:absolute;right:-70px;top:-70px;width:220px;height:220px;border:28px solid rgba(212,175,55,.35);border-radius:50%}.hero-title{font-size:34px;font-weight:900;letter-spacing:1px}.hero-title span{color:var(--gold)}
.level-card{background:#fff;border:1px solid #ead9a0;border-radius:14px;padding:14px;text-align:center;height:100%}.level-no{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;background:var(--blue);color:#fff;font-weight:800;margin-bottom:8px}.level-card h5{color:var(--primary);font-weight:900;margin:0}.level-card p{margin:0;font-size:13px;color:#666}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}.table td{white-space:nowrap;vertical-align:middle}.badge-paid{background:#dff7e8;color:#198754}.badge-pending{background:#fff3cd;color:#856404}.badge-hold{background:#fde2e2;color:#dc3545}
</style>
@endpush

@section('content')
<div class="hero-box mb-4">
      <div class="row align-items-center g-3">
        <div class="col-lg-8"><div class="hero-title">ZENITH <span>TEAM PACKAGE</span> COMMISSION</div><p class="mb-0 mt-2">20 level team income plan. Earn level-wise commission from your downline Zenith Team Package purchases.</p></div>
        <div class="col-lg-4 text-lg-end"><div class="h6 mb-1">Total Team Commission</div><div class="display-5 fw-bold text-warning">₹1100/-</div><small>Distributed in 20 levels</small></div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Income</p><h3>₹12,850</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month</p><h3>₹2,450</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Active Levels</p><h3>14/20</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Team Sales</p><h3>89</h3></div></div>
    </div>
    <div class="info-note mb-4"><b>Income Rule:</b> When a Zenith Team Package is purchased in your downline, level-wise commission is credited up to 20 levels. Total commission distribution is ₹1100 per eligible package.</div>
    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">20 Level Commission Structure</h5>
      <div class="row g-3">
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">1</span><h5>₹500</h5><p>1st Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">2</span><h5>₹200</h5><p>2nd Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">3</span><h5>₹100</h5><p>3rd Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">4</span><h5>₹75</h5><p>4th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">5</span><h5>₹50</h5><p>5th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">6</span><h5>₹40</h5><p>6th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">7</span><h5>₹30</h5><p>7th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">8</span><h5>₹20</h5><p>8th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">9</span><h5>₹20</h5><p>9th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">10</span><h5>₹15</h5><p>10th Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">11-13</span><h5>₹15</h5><p>Each Level</p></div></div>
        <div class="col-lg-3 col-md-4 col-6"><div class="level-card"><span class="level-no">14-20</span><h5>₹10</h5><p>Each Level</p></div></div>
      </div>
    </div>
    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Search Team Commission</h5>
      <div class="row g-3"><div class="col-md-3"><input type="date" class="form-control"></div><div class="col-md-3"><input type="date" class="form-control"></div><div class="col-md-3"><select class="form-select"><option>All Levels</option><option>1st Level</option><option>2nd Level</option><option>3rd Level</option><option>4th-20th Level</option></select></div><div class="col-md-3"><select class="form-select"><option>All Status</option><option>Paid</option><option>Pending</option><option>Hold</option></select></div><div class="col-12"><button class="btn btn-main"><i class="fa fa-search"></i> Search</button> <button class="btn btn-secondary rounded-pill px-4">Reset</button></div></div>
    </div>
    <div class="card-box">
      <h5 class="fw-bold mb-3">Level Wise Team Package Commission List</h5>
      <div class="table-responsive"><table class="table table-bordered align-middle"><thead><tr><th>SL</th><th>Date</th><th>Package Buyer</th><th>Buyer ID</th><th>Level</th><th>Package Name</th><th>Commission</th><th>Status</th><th>Remark</th></tr></thead><tbody>
        <tr><td>1</td><td>30 Jun 2026</td><td>Rahul Sharma</td><td>ARM2045</td><td>1st Level</td><td>Zenith Team Package</td><td>₹500</td><td><span class="badge badge-paid">Paid</span></td><td>Direct team commission</td></tr>
        <tr><td>2</td><td>29 Jun 2026</td><td>Priya Das</td><td>ARM2148</td><td>2nd Level</td><td>Zenith Team Package</td><td>₹200</td><td><span class="badge badge-paid">Paid</span></td><td>Level income credited</td></tr>
        <tr><td>3</td><td>28 Jun 2026</td><td>Amit Roy</td><td>ARM2291</td><td>3rd Level</td><td>Zenith Team Package</td><td>₹100</td><td><span class="badge badge-pending">Pending</span></td><td>Under verification</td></tr>
        <tr><td>4</td><td>26 Jun 2026</td><td>Neha Gupta</td><td>ARM2403</td><td>4th Level</td><td>Zenith Team Package</td><td>₹75</td><td><span class="badge badge-paid">Paid</span></td><td>Commission released</td></tr>
        <tr><td>5</td><td>24 Jun 2026</td><td>Suman Pal</td><td>ARM2511</td><td>8th Level</td><td>Zenith Team Package</td><td>₹20</td><td><span class="badge badge-hold">Hold</span></td><td>KYC pending</td></tr>
      </tbody></table></div>
    </div>
  </div>
@endsection
