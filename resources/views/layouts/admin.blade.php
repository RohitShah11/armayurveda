<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') | ARM Ayurveda</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
.admin-shell .sidebar{background:#1f2937}
.admin-shell .sidebar a:hover,.admin-shell .sidebar a.active,.admin-shell .sidebar-logout-btn:hover{background:#374151}
.admin-shell .topbar h5{color:#1f2937}
.admin-shell .stat-card{border-left-color:#1f2937}
.admin-shell .stat-card h3,.admin-shell .stat-card h4,.admin-shell .stat-card i{color:#1f2937}
.admin-shell .btn-main{background:#1f2937}
.admin-shell .btn-main:hover,.admin-shell .btn-main:focus{background:#111827}
.admin-shell .table thead th{background:#1f2937}
.admin-page{padding:25px}
.admin-card{background:#fff;border-radius:12px;padding:22px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.admin-card .form-control,.admin-card .form-select{border-radius:10px}
.proof-thumb{width:74px;height:54px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;background:#f8f9fa}
.detail-row{display:flex;justify-content:space-between;gap:18px;border-bottom:1px solid #eee;padding:10px 0}
.detail-row span:last-child{text-align:right}
@media(max-width:576px){.admin-page{padding:18px}.detail-row{display:block}.detail-row span:last-child{text-align:left;display:block;margin-top:4px}}
</style>

@stack('styles')
</head>
<body class="admin-shell">

<div class="sidebar" id="sidebar">
  <div class="logo-box">
    <img src="{{ asset('images/arm-ayurveda-logo.png') }}" alt="ARM Ayurveda">
  </div>
  <div class="user-box">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin">
    <h6 class="mt-2 mb-0">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</h6>
    <small>Administration</small>
  </div>
  <div class="menu-title">Admin Menu</div>

  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fa fa-house"></i>Dashboard
  </a>
  <a href="{{ route('admin.members.index') }}" class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
    <i class="fa fa-users"></i>Members
  </a>
  <a href="{{ route('admin.kyc.index') }}" class="{{ request()->routeIs('admin.kyc.*') ? 'active' : '' }}">
    <i class="fa fa-id-card"></i>KYC Requests
  </a>
  <a href="{{ route('admin.funds.index') }}" class="{{ request()->routeIs('admin.funds.*') ? 'active' : '' }}">
    <i class="fa fa-wallet"></i>Fund Requests
  </a>
  <a href="{{ route('admin.payouts.index') }}" class="{{ request()->routeIs('admin.payouts.*') ? 'active' : '' }}">
    <i class="fa fa-money-bill-transfer"></i>Payout Requests
  </a>
  <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
    <i class="fa fa-wallet"></i>Transactions
  </a>
  <a href="{{ route('admin.earn-transactions.index') }}" class="{{ request()->routeIs('admin.earn-transactions.*') ? 'active' : '' }}">
    <i class="fa fa-coins"></i>Earning Transactions
  </a>
  <a href="{{ route('admin.package-purchases.index') }}" class="{{ request()->routeIs('admin.package-purchases.*') ? 'active' : '' }}">
    <i class="fa fa-box-open"></i>Package Purchases
  </a>
  <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
    <i class="fa fa-layer-group"></i>Categories
  </a>
  <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
    <i class="fa fa-box"></i>Products
  </a>
  <a href="{{ route('admin.product-orders.index') }}" class="{{ request()->routeIs('admin.product-orders.*') ? 'active' : '' }}">
    <i class="fa fa-cart-shopping"></i>Repurchase Orders
  </a>
  <a href="{{ route('admin.zenith-pool.index') }}" class="{{ request()->routeIs('admin.zenith-pool.*') ? 'active' : '' }}">
    <i class="fa fa-sitemap"></i>Zenith Pool
  </a>
  <a href="{{ route('admin.sponsor-pool.index') }}" class="{{ request()->routeIs('admin.sponsor-pool.*') ? 'active' : '' }}">
    <i class="fa fa-network-wired"></i>Sponsor Pool
  </a>
  <a href="{{ route('admin.direct-tree.index') }}" class="{{ request()->routeIs('admin.direct-tree.*') ? 'active' : '' }}">
    <i class="fa fa-diagram-project"></i>Direct Tree
  </a>
  <a href="{{ route('admin.rank-rewards.index') }}" class="{{ request()->routeIs('admin.rank-rewards.*') ? 'active' : '' }}">
    <i class="fa fa-trophy"></i>Rank & Reward
  </a>

  <form method="POST" action="{{ route('admin.logout') }}">
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
      <h5 class="mb-0 fw-bold">@yield('page-title', 'Admin Panel')</h5>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="d-none d-md-inline text-muted small">{{ Auth::guard('admin')->user()->email ?? '' }}</span>
      <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-main btn-sm">Logout</button>
      </form>
    </div>
  </div>

  <main class="admin-page">
    @if($errors->any())
      <div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
  </main>
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
toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",preventDuplicates:true,timeOut:"3000"};
$(function(){
  @if(session('success')) toastr.success(@json(session('success'))); @endif
  @if(session('error')) toastr.error(@json(session('error'))); @endif
  @if(session('warning')) toastr.warning(@json(session('warning'))); @endif
  @if(session('info')) toastr.info(@json(session('info'))); @endif
});
</script>
@stack('scripts')
</body>
</html>
