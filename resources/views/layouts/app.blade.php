<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') | ARM Ayurveda</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="{{ asset('css/app.css') }}?v=20260804-2" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stack('styles')
</head>
<body>

<div class="sidebar" id="sidebar">
  <div class="logo-box">
    <img src="{{ asset('images/arm-ayurveda-logo.png') }}" alt="ARM Ayurveda">
  </div>
  <div class="user-box">
    @php
      $sidebarProfilePhoto = auth()->user()->profilePhotoPath();
      $sidebarProfilePhotoUrl = $sidebarProfilePhoto
          ? asset($sidebarProfilePhoto)
          : asset('images/profile-placeholder.svg');
    @endphp
    <img src="{{ $sidebarProfilePhotoUrl }}"
         onerror="this.onerror=null;this.src='{{ asset('images/profile-placeholder.svg') }}';"
         alt="{{ auth()->user()->name }}">
    <h6 class="mt-2 mb-0">Welcome, {{ auth()->user()->name ?? 'Member' }}</h6>
    <small>ID: {{ auth()->user()->member_id ?? 'ARM1001' }}</small>
  </div>
  <div class="menu-title">Main Menu</div>

   <a href="{{ route('dashboard') }}"       class="{{ request()->routeIs('dashboard')       ? 'active':'' }}"><i class="fa fa-house"></i>Dashboard</a>
    <a href="{{ route('profile') }}"         class="{{ request()->routeIs('profile')         ? 'active':'' }}"><i class="fa fa-user"></i>Profile</a>
    <a href="{{ route('profile.id-card') }}" class="{{ request()->routeIs('profile.id-card') ? 'active':'' }}"><i class="fa fa-id-card"></i>My ID Card</a>
  <!-- <a data-bs-toggle="collapse" href="#homeMenu">
    <i class="fa fa-house"></i> Home <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('dashboard','profile','kyc','change.password') ? 'show' : '' }} submenu" id="homeMenu">
    <a href="{{ route('dashboard') }}"       class="{{ request()->routeIs('dashboard')       ? 'active':'' }}">Dashboard</a>
    <a href="{{ route('profile') }}"         class="{{ request()->routeIs('profile')         ? 'active':'' }}">Profile</a>
    <a href="{{ route('kyc') }}"             class="{{ request()->routeIs('kyc')             ? 'active':'' }}">KYC</a>
    <a href="{{ route('change.password') }}" class="{{ request()->routeIs('change.password') ? 'active':'' }}">Change Password</a>
  </div> -->

  <a data-bs-toggle="collapse" href="#packageMenu">
    <i class="fa fa-box"></i> Package <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('package.*') ? 'show':'' }} submenu" id="packageMenu">
    <a href="{{ route('package.purchase') }}" class="{{ request()->routeIs('package.purchase') ? 'active':'' }}">Purchase Package</a>
  </div>

  <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.index','catalog.category','catalog.show','catalog.purchase') ? 'active':'' }}">
    <i class="fa fa-cart-arrow-down"></i> Repurchase
  </a>
  <a href="{{ route('catalog.orders') }}" class="{{ request()->routeIs('catalog.orders') ? 'active':'' }}">
    <i class="fa fa-receipt"></i> My Repurchase Orders
  </a>

  <a data-bs-toggle="collapse" href="#rechargeMenu">
    <i class="fa fa-mobile-screen"></i> Recharge <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('recharge.*') ? 'show':'' }} submenu" id="rechargeMenu">
    <!--<a href="{{ route('recharge.mobile') }}" class="{{ request()->routeIs('recharge.mobile') ? 'active':'' }}">Mobile Recharge</a>-->
    <!--<a href="{{ route('recharge.dth') }}"    class="{{ request()->routeIs('recharge.dth')    ? 'active':'' }}">DTH Recharge</a>-->
    <a href="">Mobile Recharge</a>
    <a href="">DTH Recharge</a>
  </div>

  <a data-bs-toggle="collapse" href="#teamMenu">
    <i class="fa fa-users"></i> My Team <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('team.*') ? 'show':'' }} submenu" id="teamMenu">
    <a href="{{ route('team.add-member') }}" class="{{ request()->routeIs('team.add-member') ? 'active':'' }}">Add Member</a>
    <a href="{{ route('team.direct') }}"     class="{{ request()->routeIs('team.direct')     ? 'active':'' }}">Direct Member</a>
     <a href="{{ route('team.level') }}"      class="{{ request()->routeIs('team.level')      ? 'active':'' }}">Level Wise Team</a>
    
  </div>

  <a data-bs-toggle="collapse" href="#reportMenu">
    <i class="fa fa-chart-column"></i> Report <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('report.*') ? 'show':'' }} submenu" id="reportMenu">
    <a href="{{ route('report.main-wallet') }}" class="{{ request()->routeIs('report.main-wallet') ? 'active':'' }}">Main Wallet</a>
    <a href="{{ route('report.earn-wallet') }}" class="{{ request()->routeIs('report.earn-wallet') ? 'active':'' }}">Earn Wallet</a>
    <!--<a href="{{ route('report.package') }}"     class="{{ request()->routeIs('report.package')     ? 'active':'' }}">Package Report</a>-->
    <!--<a href="{{ route('report.recharge') }}"    class="{{ request()->routeIs('report.recharge')    ? 'active':'' }}">Recharge Report</a>-->
    <!--<a href="{{ route('report.orders') }}"      class="{{ request()->routeIs('report.orders')      ? 'active':'' }}">Orders Report</a>-->
  </div>

  <a data-bs-toggle="collapse" href="#fundMenu">
    <i class="fa fa-wallet"></i> Fund Request <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('fund.*') ? 'show':'' }} submenu" id="fundMenu">
    <a href="{{ route('fund.request') }}" class="{{ request()->routeIs('fund.request') ? 'active':'' }}">Create Request</a>
    <a href="{{ route('fund.report') }}"  class="{{ request()->routeIs('fund.report')  ? 'active':'' }}">Request Record</a>
  </div>

  <a data-bs-toggle="collapse" href="#payoutMenu">
    <i class="fa fa-money-bill-transfer"></i> Payout <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('payout.*') ? 'show':'' }} submenu" id="payoutMenu">
    <a href="{{ route('payout.request') }}" class="{{ request()->routeIs('payout.request') ? 'active':'' }}">Create Request</a>
    <a href="{{ route('payout.list') }}"    class="{{ request()->routeIs('payout.list')    ? 'active':'' }}">Previous List</a>
  </div>

  <a data-bs-toggle="collapse" href="#incomeMenu">
    <i class="fa fa-sack-dollar"></i> Income Summary <i class="fa fa-angle-down ms-auto"></i>
  </a>
  <div class="collapse {{ request()->routeIs('income.*') ? 'show':'' }} submenu" id="incomeMenu">
    <!--<a href="{{ route('income.startup') }}"            class="{{ request()->routeIs('income.startup')            ? 'active':'' }}">Start Up Package Level Commission</a>-->
    <a href="{{ route('income.recharge-cashback') }}"  class="{{ request()->routeIs('income.recharge-cashback')  ? 'active':'' }}">Mobile & DTH Recharge Cashback</a>
    <a href="{{ route('income.zenith-benefit') }}"     class="{{ request()->routeIs('income.zenith-benefit')     ? 'active':'' }}">Zenith Package Return Benefit</a>
    <a href="{{ route('income.product-repurchase') }}" class="{{ request()->routeIs('income.product-repurchase') ? 'active':'' }}">Product Repurchase Bonus</a>
    <!--<a href="{{ route('income.zenith-pool') }}"        class="{{ request()->routeIs('income.zenith-pool')        ? 'active':'' }}">Monthly Zenith Pool Income</a>-->
    <a href="{{ route('income.non-working-pool') }}"   class="{{ request()->routeIs('income.non-working-pool')   ? 'active':'' }}">Non-Working Global Pool Income</a>
    <a href="{{ route('income.zenith-team') }}"        class="{{ request()->routeIs('income.zenith-team')        ? 'active':'' }}">Zenith Team Package Commission</a>
    <a href="{{ route('income.sponsor-pool') }}"       class="{{ request()->routeIs('income.sponsor-pool')       ? 'active':'' }}">Sponsor Global Pool Income</a>
    <a href="{{ route('income.business-expansion') }}" class="{{ request()->routeIs('income.business-expansion') ? 'active':'' }}">Business Expansion Incentive Bonus</a>
    <a href="{{ route('income.rank-reward') }}"        class="{{ request()->routeIs('income.rank-reward')        ? 'active':'' }}">Rank & Reward</a>
  </div>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="sidebar-logout-btn">
      <i class="fa fa-right-from-bracket"></i> Logout
    </button>
  </form>
</div>

<div class="content" id="content">
  <div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
      <button class="toggle-btn" onclick="toggleSidebar()"><i class="fa fa-bars"></i></button>
      <h5 class="mb-0 fw-bold">@yield('page-title','Dashboard')</h5>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="d-none d-md-inline text-muted small">{{ auth()->user()->member_id ?? 'ARM1001' }}</span>
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-main btn-sm">Logout</button>
      </form>
    </div>
  </div>

  
    @yield('content')
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar(){
  const s=document.getElementById('sidebar'),c=document.getElementById('content');
  if(window.innerWidth<=991){s.classList.toggle('show');}
  else{s.classList.toggle('collapsed');c.classList.toggle('full');}
}
</script>
<script>
$(document).ready(function () {

    @if(session('success'))
        toastr.success(@json(session('success')));
    @endif

    @if(session('error'))
        toastr.error(@json(session('error')));
    @endif

    @if(session('warning'))
        toastr.warning(@json(session('warning')));
    @endif

    @if(session('info'))
        toastr.info(@json(session('info')));
    @endif

    @if($errors->any())
        toastr.error("{{ $errors->first() }}");
    @endif

});
</script>
<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showDuration": "300",
    "hideDuration": "300",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
</script>
@stack('scripts')
</body>
</html>
