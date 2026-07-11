@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
.dashboard-

.stat-card{
  background:#fff;
  border-radius:18px;
  padding:22px;
  box-shadow:0 8px 25px rgba(0,0,0,.07);
  height:100%;
  border-left:5px solid var(--primary);
}

.stat-card i{
  font-size:34px;
  color:var(--primary);
}

.stat-card h4{
  font-weight:900;
  color:var(--primary);
}

.quick-card{
  background:#fff;
  border-radius:18px;
  padding:22px;
  box-shadow:0 8px 25px rgba(0,0,0,.07);
  height:100%;
  text-align:center;
}

.quick-card i{
  width:58px;
  height:58px;
  border-radius:50%;
  background:var(--light);
  color:var(--primary);
  display:flex;
  align-items:center;
  justify-content:center;
  margin:0 auto 15px;
  font-size:25px;
}

.table-box{
  background:#fff;
  border-radius:18px;
  padding:22px;
  box-shadow:0 8px 25px rgba(0,0,0,.07);
}

.table thead th{
  background:var(--primary);
  color:#fff;
}

.btn-main{
  background:var(--primary);
  color:#fff;
  border-radius:25px;
  font-weight:700;
}

.btn-main:hover{
  background:var(--dark);
  color:#fff;
}

.badge-success{
  background:#dff7e8;
  color:#198754;
}

.badge-pending{
  background:#fff3cd;
  color:#856404;
}

@media(max-width:991px){
  

  

  
}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="d-flex justify-content-between">
            <div>
              <p>Main Wallet</p>
              <h4>₹12,500</h4>
            </div>
            <i class="fa fa-wallet"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="d-flex justify-content-between">
            <div>
              <p>Earn Wallet</p>
              <h4>₹8,750</h4>
            </div>
            <i class="fa fa-sack-dollar"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="d-flex justify-content-between">
            <div>
              <p>Total Team</p>
              <h4>126</h4>
            </div>
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="d-flex justify-content-between">
            <div>
              <p>Active Package</p>
              <h4>Zenith</h4>
            </div>
            <i class="fa fa-box-open"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <p>Direct Members</p>
          <h4>18</h4>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <p>Level Members</p>
          <h4>108</h4>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <p>Total Recharge</p>
          <h4>₹34,200</h4>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <p>Total Orders</p>
          <h4>42</h4>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-3 col-6">
        <div class="quick-card">
          <i class="fa fa-user-plus"></i>
          <h6>Add Member</h6>
          <a href="{{ url('#') }}" class="btn btn-main btn-sm">Open</a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="quick-card">
          <i class="fa fa-mobile-screen"></i>
          <h6>Mobile Recharge</h6>
          <a href="{{ url('#') }}" class="btn btn-main btn-sm">Recharge</a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="quick-card">
          <i class="fa fa-box"></i>
          <h6>Purchase Package</h6>
          <a href="{{ url('#') }}" class="btn btn-main btn-sm">Buy</a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="quick-card">
          <i class="fa fa-money-bill-transfer"></i>
          <h6>Payout Request</h6>
          <a href="{{ url('#') }}" class="btn btn-main btn-sm">Request</a>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-8">
        <div class="table-box">
          <h5 class="fw-bold mb-3">Recent Transactions</h5>
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>28 Jun 2026</td>
                  <td>Package Purchase</td>
                  <td>₹10,500</td>
                  <td><span class="badge badge-success">Success</span></td>
                </tr>
                <tr>
                  <td>27 Jun 2026</td>
                  <td>Mobile Recharge</td>
                  <td>₹299</td>
                  <td><span class="badge badge-success">Success</span></td>
                </tr>
                <tr>
                  <td>26 Jun 2026</td>
                  <td>Payout Request</td>
                  <td>₹2,000</td>
                  <td><span class="badge badge-pending">Pending</span></td>
                </tr>
                <tr>
                  <td>25 Jun 2026</td>
                  <td>Income Credit</td>
                  <td>₹750</td>
                  <td><span class="badge badge-success">Success</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="table-box">
          <h5 class="fw-bold mb-3">Profile Status</h5>
          <p><b>Name:</b> Member Name</p>
          <p><b>Member ID:</b> ARM1001</p>
          <p><b>KYC:</b> <span class="badge badge-pending">Pending</span></p>
          <p><b>Package:</b> Zenith Package</p>
          <p><b>Joining Date:</b> 28 Jun 2026</p>
          <a href="{{ url('#') }}" class="btn btn-main w-100">Complete KYC</a>
        </div>
      </div>
    </div>

    <div class="table-box">
      <h5 class="fw-bold mb-3">Income Summary</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Income Type</th>
              <th>Today</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>START UP PACKAGE LEVEL COMMISSION</td>
              <td>₹0</td>
              <td>₹1,200</td>
            </tr>
            <tr>
              <td>Mobile & DTH Recharge Cashback and Team Bonus</td>
              <td>₹45</td>
              <td>₹850</td>
            </tr>
            <tr>
              <td>Zenith Package Return Benefit</td>
              <td>₹150</td>
              <td>₹3,000</td>
            </tr>
            <tr>
              <td>Product Repurchase Discount and Network Bonus</td>
              <td>₹0</td>
              <td>₹950</td>
            </tr>
            <tr>
              <td>Monthly Zenith Pool Income</td>
              <td>₹0</td>
              <td>₹500</td>
            </tr>
            <tr>
              <td>Zenith Non-Working Global Pool Income</td>
              <td>₹0</td>
              <td>₹700</td>
            </tr>
            <tr>
              <td>Zenith Team Package Commission</td>
              <td>₹250</td>
              <td>₹2,500</td>
            </tr>
            <tr>
              <td>Zenith Package Sponsor Global Pool Income</td>
              <td>₹0</td>
              <td>₹600</td>
            </tr>
            <tr>
              <td>BUSINESS EXPANSION INCENTIVE BONUS</td>
              <td>₹0</td>
              <td>₹0</td>
            </tr>
            <tr>
              <td>Leadership Achievement Bonus</td>
              <td>₹0</td>
              <td>₹0</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection
