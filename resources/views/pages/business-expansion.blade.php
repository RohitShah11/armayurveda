@extends('layouts.app')

@section('title', 'Business Expansion Incentive Bonus')
@section('page-title', 'Business Expansion Incentive Bonus')

@push('styles')
<style>
.page-.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}.stat-card{border-left:5px solid var(--primary)}.stat-card h3{font-weight:900;color:var(--primary)}.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}.btn-main:hover{background:var(--dark);color:#fff}.hero{background:linear-gradient(135deg,#071b45,#0a2f75);color:#fff;border-radius:20px;overflow:hidden}.hero-left{padding:35px}.hero-title{font-size:34px;font-weight:900;color:#fff}.hero-title span{color:var(--gold)}.hero-note{background:rgba(255,255,255,.1);border-left:4px solid var(--gold);padding:15px;border-radius:12px}.pool-card{border:1px solid #eee;border-radius:18px;padding:20px;height:100%;position:relative;overflow:hidden}.pool-card:before{content:"";position:absolute;right:-35px;top:-35px;width:110px;height:110px;border-radius:50%;background:rgba(212,175,55,.14)}.pool-badge{width:74px;height:74px;border-radius:50%;display:grid;place-items:center;font-weight:900;margin-bottom:12px;color:#fff;background:linear-gradient(135deg,var(--gold),#9b6a00);box-shadow:0 8px 18px rgba(0,0,0,.12)}.pool-card.silver .pool-badge{background:linear-gradient(135deg,#cfd6df,#747b83)}.pool-card.diamond .pool-badge{background:linear-gradient(135deg,#78c7ff,#0d6efd)}.pool-card.platinum .pool-badge{background:linear-gradient(135deg,#ddd,#666)}.pool-card.royal .pool-badge{background:linear-gradient(135deg,#f7d35a,#c79500)}.requirement{display:inline-block;background:var(--light);color:var(--primary);font-weight:800;border-radius:20px;padding:7px 14px}.form-control,.form-select{height:46px;border-radius:12px}.table thead th{background:var(--primary);color:#fff;white-space:nowrap}.table td{white-space:nowrap;vertical-align:middle}.badge-paid{background:#dff7e8;color:#198754}.badge-process{background:#fff3cd;color:#856404}.badge-qualified{background:#e8f0ff;color:#0d6efd}.info-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}.calc-box{background:#071b45;color:#fff;border-radius:18px;padding:22px}.calc-row{display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.18);padding:10px 0;gap:12px}.calc-row span:last-child{font-weight:800;text-align:right}@media(max-width:576px){.page-.calc-row{display:block}.calc-row span:last-child{display:block;text-align:left;margin-top:4px}.hero-left{padding:22px}}
</style>
@endpush

@section('content')
<div class="hero mb-4">
      <div class="row g-0 align-items-center">
        <div class="col-lg-7 hero-left">
          <div class="small text-uppercase fw-bold text-warning mb-2">10. ARM PVT. LTD.</div>
          <h1 class="hero-title">Business Expansion <span>Incentive Bonus</span></h1>
          <p class="mb-3">A performance based bonus for members who achieve monthly business milestones and qualify for achievement pools from Bronze to Royal.</p>
          <div class="hero-note"><b>Example:</b> If monthly company turnover is ₹10 crore, 3% is allocated for Business Expansion Incentive Bonus and distributed across 6 pools.</div>
        </div>
        <div class="col-lg-5 p-4">
          <div class="calc-box">
            <h5 class="fw-bold mb-3"><i class="fa fa-calculator"></i> Pool Calculation</h5>
            <div class="calc-row"><span>Company Turnover</span><span>₹0</span></div>
            <div class="calc-row"><span>Bonus Percentage</span><span>3%</span></div>
            <div class="calc-row"><span>Total Bonus Pool</span><span>₹0</span></div>
            <div class="calc-row"><span>Total Pools</span><span>6 Pools</span></div>
            <div class="calc-row"><span>Per Pool Allocation</span><span>₹0</span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>This Month Bonus</p><h3>₹0</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Current Pool</p><h3>Gold</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Monthly Business</p><h3>₹0</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Received</p><h3 class="text-success">₹0</h3></div></div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">6 Achievement Pools</h5>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6"><div class="pool-card"><div class="pool-badge">BR</div><h5 class="fw-bold">Bronze Pool</h5><p class="requirement">Requirement: ₹5,000</p><p class="mb-0">Example: ₹5,00,000 ÷ 1000 members = ₹500 each.</p></div></div>
        <div class="col-lg-4 col-md-6"><div class="pool-card silver"><div class="pool-badge">SI</div><h5 class="fw-bold">Silver Pool</h5><p class="requirement">Requirement: ₹20,000</p><p class="mb-0">Example: ₹5,00,000 ÷ 250 members = ₹2,000 each.</p></div></div>
        <div class="col-lg-4 col-md-6"><div class="pool-card"><div class="pool-badge">GO</div><h5 class="fw-bold">Gold Pool</h5><p class="requirement">Requirement: ₹50,000</p><p class="mb-0">Example: ₹5,00,000 ÷ 100 members = ₹5,000 each.</p></div></div>
        <div class="col-lg-4 col-md-6"><div class="pool-card diamond"><div class="pool-badge">DI</div><h5 class="fw-bold">Diamond Pool</h5><p class="requirement">Requirement: ₹1,00,000</p><p class="mb-0">Example: ₹5,00,000 ÷ 50 members = ₹10,000 each.</p></div></div>
        <div class="col-lg-4 col-md-6"><div class="pool-card platinum"><div class="pool-badge">PL</div><h5 class="fw-bold">Platinum Pool</h5><p class="requirement">Requirement: ₹2,50,000</p><p class="mb-0">Example: ₹5,00,000 ÷ 20 members = ₹25,000 each.</p></div></div>
        <div class="col-lg-4 col-md-6"><div class="pool-card royal"><div class="pool-badge">RO</div><h5 class="fw-bold">Royal Pool</h5><p class="requirement">Requirement: ₹5,00,000</p><p class="mb-0">Example: ₹5,00,000 ÷ 10 members = ₹50,000 each.</p></div></div>
      </div>
    </div>

    <div class="info-note mb-4"><b>Note:</b> For all slabs, non-working global pool income will not be included in the monthly income requirement for Business Expansion Incentive Bonus.</div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Bonus Report</h5>
      <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Month</label><input type="month" class="form-control" value="2026-06"></div>
        <div class="col-md-3"><label class="form-label">Pool</label><select class="form-select"><option>All Pools</option><option>Bronze</option><option>Silver</option><option>Gold</option><option>Diamond</option><option>Platinum</option><option>Royal</option></select></div>
        <div class="col-md-3"><label class="form-label">Status</label><select class="form-select"><option>All Status</option><option>Qualified</option><option>Processing</option><option>Paid</option></select></div>
        <div class="col-md-3 d-flex align-items-end"><button class="btn btn-main w-100"><i class="fa fa-search"></i> Search</button></div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h5 class="fw-bold mb-0">Business Expansion Incentive Bonus List</h5><button class="btn btn-main btn-sm"><i class="fa fa-download"></i> Export</button></div>
      {{-- <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead><tr><th>SL</th><th>Month</th><th>Pool Name</th><th>Monthly Business</th><th>Pool Amount</th><th>Qualified Members</th><th>Per Member Bonus</th><th>Status</th><th>Payment Date</th><th>Remark</th></tr></thead>
          <tbody>
            <tr><td>1</td><td>Jun 2026</td><td>Gold Pool</td><td>₹58,200</td><td>₹5,00,000</td><td>100</td><td>₹5,000</td><td><span class="badge badge-process">Processing</span></td><td>Pending</td><td>Eligible for Gold Pool</td></tr>
            <tr><td>2</td><td>May 2026</td><td>Silver Pool</td><td>₹24,600</td><td>₹5,00,000</td><td>250</td><td>₹2,000</td><td><span class="badge badge-paid">Paid</span></td><td>05 Jun 2026</td><td>Paid successfully</td></tr>
            <tr><td>3</td><td>Apr 2026</td><td>Bronze Pool</td><td>₹8,900</td><td>₹5,00,000</td><td>1000</td><td>₹500</td><td><span class="badge badge-paid">Paid</span></td><td>05 May 2026</td><td>Bronze bonus credited</td></tr>
            <tr><td>4</td><td>Mar 2026</td><td>Diamond Pool</td><td>₹1,20,000</td><td>₹5,00,000</td><td>50</td><td>₹10,000</td><td><span class="badge badge-qualified">Qualified</span></td><td>10 Apr 2026</td><td>Diamond milestone achieved</td></tr>
          </tbody>
        </table>
      </div> --}}
    </div>
  </div>
@endsection
