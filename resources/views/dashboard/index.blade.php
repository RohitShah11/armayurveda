@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
  .dashboard-welcome{
    background:linear-gradient(135deg,var(--primary),var(--dark));
    border-radius:20px;
    color:#fff;
    padding:24px 28px;
    box-shadow:0 10px 30px rgba(27,94,32,.2);
  }
  .dashboard-welcome p{color:rgba(255,255,255,.82)}
  .dashboard-welcome .member-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:7px 13px;
    border-radius:30px;
    background:rgba(255,255,255,.15);
    font-size:13px;
    font-weight:700;
  }
  .stat-card p{margin-bottom:7px;color:#6c757d;font-size:14px;font-weight:700}
  .stat-card h4{margin:0;font-size:24px;overflow-wrap:anywhere}
  .stat-card .stat-note{display:block;margin-top:8px;color:#88918a;font-size:12px}
  .quick-card{transition:transform .2s ease,box-shadow .2s ease}
  .quick-card:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,0,0,.1)}
  .quick-card h6{min-height:38px;font-weight:800}
  .badge-credit,.badge-approved,.badge-active{
    background:#dff7e8;
    color:#198754;
  }
  .badge-debit,.badge-rejected,.badge-blocked{
    background:#fde8e8;
    color:#dc3545;
  }
  .badge-pending,.badge-not-submitted,.badge-inactive{
    background:#fff3cd;
    color:#856404;
  }
  .transaction-amount{font-weight:800;white-space:nowrap}
  .transaction-amount.credit{color:#198754}
  .transaction-amount.debit{color:#dc3545}
  .empty-state{padding:32px 15px!important;color:#7b847d!important;text-align:center}
  @media(max-width:575px){
    .dashboard-body{padding:18px 14px}
    .dashboard-welcome{padding:20px}
    .stat-card,.quick-card,.table-box{padding:18px}
  }
</style>
@endpush

@section('content')
<div class="dashboard-body">
  <section class="dashboard-welcome mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div>
        <p class="mb-1">Welcome back</p>
        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
        <p class="mb-0">Here is the latest activity for your ARM Ayurveda account.</p>
      </div>
      <span class="member-pill"><i class="fa fa-id-card"></i> {{ $user->member_id ?: 'ID pending' }}</span>
    </div>
  </section>

  <div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between gap-3">
          <div>
            <p>Main Wallet</p>
            <h4>₹{{ number_format((float) $user->main_wallet, 2) }}</h4>
            <span class="stat-note">Available balance</span>
          </div>
          <i class="fa fa-wallet"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between gap-3">
          <div>
            <p>Earn Wallet</p>
            <h4>₹{{ number_format((float) $user->earning_wallet, 2) }}</h4>
            <span class="stat-note">Total available earnings</span>
          </div>
          <i class="fa fa-sack-dollar"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between gap-3">
          <div>
            <p>Total Team</p>
            <h4>{{ number_format($totalTeam) }}</h4>
            <span class="stat-note">All members in your network</span>
          </div>
          <i class="fa fa-users"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between gap-3">
          <div>
            <p>Active Package</p>
            <h4>{{ $activePackage ?: 'Not purchased' }}</h4>
            <span class="stat-note">Current membership package</span>
          </div>
          <i class="fa fa-box-open"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <p>Direct Members</p>
        <h4>{{ number_format($directMembers) }}</h4>
        <span class="stat-note">Members sponsored by you</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <p>Level Members</p>
        <h4>{{ number_format($levelMembers) }}</h4>
        <span class="stat-note">Members below your direct level</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <p>Repurchase Value</p>
        <h4>₹{{ number_format($totalOrderValue, 2) }}</h4>
        <span class="stat-note">Value of all product orders</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <p>Total Orders</p>
        <h4>{{ number_format($totalOrders) }}</h4>
        <span class="stat-note">Your product repurchases</span>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-lg-3 col-6">
      <div class="quick-card">
        <i class="fa fa-user-plus"></i>
        <h6>Add Member</h6>
        <a href="{{ route('team.add-member') }}" class="btn btn-main btn-sm">Open</a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="quick-card">
        <i class="fa fa-mobile-screen"></i>
        <h6>Mobile Recharge</h6>
        <!-- <a href="{{ route('recharge.mobile') }}" class="btn btn-main btn-sm">Recharge</a> -->
        <a href="#" class="btn btn-main btn-sm">Recharge</a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="quick-card">
        <i class="fa fa-box"></i>
        <h6>Purchase Package</h6>
        <a href="{{ route('package.purchase') }}" class="btn btn-main btn-sm">Buy</a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="quick-card">
        <i class="fa fa-money-bill-transfer"></i>
        <h6>Payout Request</h6>
        <a href="{{ route('payout.request') }}" class="btn btn-main btn-sm">Request</a>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-xl-8">
      <div class="table-box h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-bold mb-0">Recent Transactions</h5>
          <!-- <a href="{{ route('report.main-wallet') }}" class="small text-decoration-none">View wallet</a> -->
        </div>
        <div class="table-responsive">
          <table class="table table-bordered align-middle mb-0">
            <thead>
              <tr>
                <th>Date</th>
                <th>Activity</th>
                <th>Amount</th>
                <th>Type</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentTransactions as $transaction)
                @php
                  $direction = strtolower($transaction['direction']);
                @endphp
                <tr>
                  <td class="text-nowrap">{{ $transaction['date']?->format('d M Y') ?: '—' }}</td>
                  <td>{{ $transaction['description'] }}</td>
                  <td class="transaction-amount {{ $direction }}">
                    {{ $direction === 'credit' ? '+' : ($direction === 'debit' ? '−' : '') }}₹{{ number_format($transaction['amount'], 2) }}
                  </td>
                  <td><span class="badge badge-{{ $direction }}">{{ $transaction['direction'] }}</span></td>
                </tr>
              @empty
                <tr><td colspan="4" class="empty-state">No wallet transactions yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      @php
        $kycKey = strtolower(str_replace(' ', '-', $kycStatus));
        $memberStatusKey = strtolower($user->status ?: 'inactive');
      @endphp
      <div class="table-box h-100">
        <h5 class="fw-bold mb-3">Profile Status</h5>
        <p><b>Name:</b> {{ $user->name }}</p>
        <p><b>Member ID:</b> {{ $user->member_id ?: 'Pending' }}</p>
        <p><b>Account:</b> <span class="badge badge-{{ $memberStatusKey }}">{{ $user->status ?: 'Inactive' }}</span></p>
        <p><b>KYC:</b> <span class="badge badge-{{ $kycKey }}">{{ $kycStatus }}</span></p>
        <p><b>Package:</b> {{ $activePackage ?: 'Not purchased' }}</p>
        <p><b>Joining Date:</b> {{ $user->created_at?->format('d M Y') ?: '—' }}</p>
        <a href="{{ route('kyc') }}" class="btn btn-main w-100">
          {{ strtolower($kycStatus) === 'approved' ? 'View KYC' : 'Complete KYC' }}
        </a>
      </div>
    </div>
  </div>

  <div class="table-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0">Income Summary</h5>
      <a href="{{ route('report.earn-wallet') }}" class="small text-decoration-none">View earnings</a>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-0">
        <thead>
          <tr>
            <th>Income Type</th>
            <th>Today</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($incomeSummary as $income)
            <tr>
              <td>{{ $income['label'] }}</td>
              <td>₹{{ number_format($income['today'], 2) }}</td>
              <td class="fw-bold">₹{{ number_format($income['total'], 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
