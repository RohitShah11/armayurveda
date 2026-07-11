@extends('layouts.app')

@section('title', 'Zenith Package Sponsor Global Pool Income')
@section('page-title', 'Zenith Package Sponsor Global Pool Income')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}.stat-card{border-left:5px solid var(--primary)}.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:48px;border-radius:12px}.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}.btn-main:hover{background:var(--dark);color:#fff}.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}.table thead th{background:var(--primary);color:#fff;white-space:nowrap}.table td{white-space:nowrap;vertical-align:middle}
.badge-paid{background:#dff7e8;color:#198754}.badge-pending{background:#fff3cd;color:#856404}.badge-hold{background:#fde2e2;color:#dc3545}.badge-level{background:#e9eefb;color:#071b3d;border-radius:20px;padding:7px 12px;font-weight:800}
.plan-box{background:linear-gradient(135deg,#061837,#0b2d64);color:#fff;border-radius:18px;padding:25px;height:100%;position:relative;overflow:hidden}.plan-box:before{content:"";position:absolute;right:-60px;top:-60px;width:180px;height:180px;border-radius:50%;background:rgba(212,175,55,.18)}
.plan-title{font-weight:900;color:#ffe799;text-transform:uppercase}.level-card{background:#fff;border:1px solid #ead28a;border-radius:14px;padding:14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;color:#071b3d}.level-card b:last-child{color:#b00020;font-size:20px}
.feature{display:flex;align-items:flex-start;gap:12px;margin-top:15px}.feature i{background:var(--gold);color:#061837;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex:0 0 36px}.formula-box{background:#fff8df;border:1px dashed var(--gold);border-radius:16px;padding:18px}.formula-box h6{color:var(--primary);font-weight:900}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Pool Income</p><h3>₹11,750</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Direct Entries</p><h3>42</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Paid Income</p><h3 class="text-success">₹9,250</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Pending Income</p><h3 class="text-warning">₹2,500</h3></div></div>
    </div>

    <div class="info-note mb-4"><b>Income Rule:</b> When a direct referral purchases the Zenith Package, one entry ID is added to the Zenith Package Sponsor Global Pool. More direct referrals create more pool entries and higher earning opportunity.</div>

    <div class="row g-4 mb-4">
      <div class="col-lg-5">
        <div class="plan-box">
          <h4 class="plan-title mb-3"><i class="fa fa-users-rays"></i> 6 Levels of Working Global Pool Income</h4>
          <div class="level-card"><span><b>Level 1</b></span><b>₹250</b></div>
          <div class="level-card"><span><b>Level 2</b></span><b>₹500</b></div>
          <div class="level-card"><span><b>Level 3</b></span><b>₹1,000</b></div>
          <div class="level-card"><span><b>Level 4</b></span><b>₹2,000</b></div>
          <div class="level-card"><span><b>Level 5</b></span><b>₹4,000</b></div>
          <div class="level-card"><span><b>Level 6</b></span><b>₹8,000</b></div>
          <div class="feature"><i class="fa fa-user-plus"></i><div><b>Refer & Earn</b><br><small>Every direct Zenith Package purchase adds one ID to your sponsor global pool.</small></div></div>
          <div class="feature"><i class="fa fa-gift"></i><div><b>Attractive Rewards</b><br><small>Income grows with active sponsorship and pool expansion.</small></div></div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card-box h-100">
          <h5 class="fw-bold mb-3">Search Sponsor Global Pool Income</h5>
          <div class="row g-3">
            <div class="col-md-4"><label class="form-label">From Date</label><input type="date" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">To Date</label><input type="date" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Level</label><select class="form-select"><option>All Levels</option><option>Level 1</option><option>Level 2</option><option>Level 3</option><option>Level 4</option><option>Level 5</option><option>Level 6</option></select></div>
            <div class="col-md-4"><label class="form-label">Status</label><select class="form-select"><option>All Status</option><option>Paid</option><option>Pending</option><option>Hold</option></select></div>
            <div class="col-md-8"><label class="form-label">Search Member / ID</label><input type="text" class="form-control" placeholder="Enter member name or ID"></div>
            <div class="col-12 d-flex gap-2 flex-wrap mt-2"><button class="btn btn-main"><i class="fa fa-search"></i> Search</button><button class="btn btn-secondary rounded-pill px-4">Reset</button><button class="btn btn-gold"><i class="fa fa-file-export"></i> Export</button></div>
          </div>
          <div class="formula-box mt-4">
            <h6>Example</h6>
            <p class="mb-0">If you refer 10 members and all 10 purchase Zenith Package, 10 separate IDs will enter the Sponsor Global Pool.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h5 class="fw-bold mb-0">Sponsor Global Pool Income List</h5><span class="badge bg-dark rounded-pill">Working Pool Income</span></div>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead><tr><th>SL</th><th>Date</th><th>Entry ID</th><th>Direct Member</th><th>Package</th><th>Level</th><th>Income</th><th>Status</th><th>Payment Date</th><th>Remark</th></tr></thead>
          <tbody>
            <tr><td>1</td><td>30 Jun 2026</td><td>ZGPI10021</td><td>Rahul Sharma<br><small>ARM1025</small></td><td>Zenith Package</td><td><span class="badge-level">Level 1</span></td><td class="fw-bold text-success">₹250</td><td><span class="badge badge-paid">Paid</span></td><td>30 Jun 2026</td><td>Direct sponsor pool entry</td></tr>
            <tr><td>2</td><td>28 Jun 2026</td><td>ZGPI10020</td><td>Suman Das<br><small>ARM1031</small></td><td>Zenith Package</td><td><span class="badge-level">Level 2</span></td><td class="fw-bold text-success">₹500</td><td><span class="badge badge-paid">Paid</span></td><td>29 Jun 2026</td><td>Pool level income credited</td></tr>
            <tr><td>3</td><td>25 Jun 2026</td><td>ZGPI10019</td><td>Priya Singh<br><small>ARM1042</small></td><td>Zenith Package</td><td><span class="badge-level">Level 3</span></td><td class="fw-bold text-success">₹1,000</td><td><span class="badge badge-pending">Pending</span></td><td>-</td><td>Processing</td></tr>
            <tr><td>4</td><td>22 Jun 2026</td><td>ZGPI10018</td><td>Amit Roy<br><small>ARM1048</small></td><td>Zenith Package</td><td><span class="badge-level">Level 4</span></td><td class="fw-bold text-success">₹2,000</td><td><span class="badge badge-paid">Paid</span></td><td>23 Jun 2026</td><td>Approved</td></tr>
            <tr><td>5</td><td>18 Jun 2026</td><td>ZGPI10017</td><td>Neha Gupta<br><small>ARM1053</small></td><td>Zenith Package</td><td><span class="badge-level">Level 5</span></td><td class="fw-bold text-success">₹4,000</td><td><span class="badge badge-hold">Hold</span></td><td>-</td><td>KYC verification pending</td></tr>
            <tr><td>6</td><td>15 Jun 2026</td><td>ZGPI10016</td><td>Bikash Mondal<br><small>ARM1060</small></td><td>Zenith Package</td><td><span class="badge-level">Level 6</span></td><td class="fw-bold text-success">₹8,000</td><td><span class="badge badge-pending">Pending</span></td><td>-</td><td>Awaiting monthly closing</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
