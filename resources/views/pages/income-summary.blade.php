@extends('layouts.app')

@section('title', 'Income Summary')
@section('page-title', 'Income Summary')

@push('styles')
<style>
.income-directory{padding:25px;min-height:calc(100vh - 72px);background:#f4f8f2}
.income-directory-hero{position:relative;overflow:hidden;background:linear-gradient(135deg,#174f25,#08743b);color:#fff;border-radius:22px;padding:34px 36px;box-shadow:0 16px 38px rgba(16,86,44,.18)}
.income-directory-hero:after{content:"";position:absolute;width:240px;height:240px;border:1px solid rgba(255,255,255,.15);border-radius:50%;right:-55px;top:-100px;box-shadow:0 0 0 42px rgba(255,255,255,.04)}
.income-directory-kicker{display:block;font-size:12px;font-weight:800;letter-spacing:1.8px;text-transform:uppercase;color:#c8f5d5;margin-bottom:9px}
.income-directory-hero h1{font-size:clamp(29px,4vw,43px);font-weight:800;margin:0 0 8px}
.income-directory-hero p{max-width:680px;margin:0;color:rgba(255,255,255,.84);font-size:16px}
.income-directory-count{position:absolute;z-index:1;right:34px;top:29px;width:112px;height:82px;border:1px solid rgba(255,255,255,.22);border-radius:18px;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(255,255,255,.08)}
.income-directory-count strong{font-size:28px;line-height:1}.income-directory-count span{font-size:11px;margin-top:7px}
.income-directory-heading{display:flex;justify-content:space-between;align-items:end;gap:20px;margin:29px 0 14px}.income-directory-heading h2{font-size:27px;font-weight:800;margin:3px 0 0;color:#17341d}.income-directory-heading p{margin:0;color:#708176;font-size:14px}
.income-directory-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px}
.income-report-card{display:grid;grid-template-columns:58px 1fr 24px;align-items:center;gap:16px;min-height:112px;padding:19px 20px;background:#fff;border:1px solid #dde8df;border-radius:17px;color:#15271a;text-decoration:none;box-shadow:0 8px 22px rgba(37,75,47,.055);transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease}
.income-report-card:hover,.income-report-card:focus{color:#15271a;transform:translateY(-3px);border-color:#2e7d32;box-shadow:0 14px 28px rgba(37,94,53,.13)}
.income-report-card-icon{width:58px;height:58px;border-radius:15px;background:#e8f5e9;color:#16823b;display:flex;align-items:center;justify-content:center;font-size:23px}
.income-report-card h3{font-size:16px;font-weight:800;margin:0 0 5px}.income-report-card p{font-size:13px;line-height:1.35;color:#728078;margin:0}.income-report-card-arrow{color:#16823b;font-size:15px;transition:transform .2s}.income-report-card:hover .income-report-card-arrow{transform:translateX(4px)}
@media(max-width:1199px){.income-directory-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:767px){.income-directory{padding:16px}.income-directory-hero{padding:26px 22px}.income-directory-count{display:none}.income-directory-heading{display:block}.income-directory-heading p{margin-top:6px}.income-directory-grid{grid-template-columns:1fr}.income-report-card{min-height:102px;padding:16px}}
</style>
@endpush

@section('content')
@php
  $reports = [
    ['route' => 'income.recharge-cashback', 'icon' => 'fa-mobile-screen-button', 'title' => 'Mobile & DTH Recharge Cashback', 'description' => 'View cashback earned from mobile and DTH recharges.'],
    ['route' => 'income.zenith-benefit', 'icon' => 'fa-box-open', 'title' => 'Zenith Package Return Benefit', 'description' => 'Review return benefits credited from the Zenith package.'],
    ['route' => 'income.product-repurchase', 'icon' => 'fa-cart-arrow-down', 'title' => 'Product Repurchase Bonus', 'description' => 'Track income generated from product repurchases.'],
    ['route' => 'income.non-working-pool', 'icon' => 'fa-circle-nodes', 'title' => 'Non-Working Global Pool Income', 'description' => 'Check global pool progress, levels and credited income.'],
    ['route' => 'income.zenith-team', 'icon' => 'fa-users', 'title' => 'Zenith Team Package Commission', 'description' => 'View level-wise commission from team package purchases.'],
    ['route' => 'income.sponsor-pool', 'icon' => 'fa-sitemap', 'title' => 'Sponsor Global Pool Income', 'description' => 'Review sponsor pool entries, progress and earnings.'],
    ['route' => 'income.business-expansion', 'icon' => 'fa-chart-line', 'title' => 'Business Expansion Incentive Bonus', 'description' => 'Track business expansion incentives and qualification.'],
    ['route' => 'income.rank-reward', 'icon' => 'fa-trophy', 'title' => 'Rank & Reward', 'description' => 'See current rank progress, achievements and rewards.'],
  ];
@endphp
<main class="income-directory">
  <section class="income-directory-hero">
    <span class="income-directory-kicker">Income Reports</span>
    <h1>All Income Reports</h1>
    <p>Select a report below to open its complete details, filters and earning records.</p>
    <div class="income-directory-count"><strong>{{ count($reports) }}</strong><span>REPORTS AVAILABLE</span></div>
  </section>
  <div class="income-directory-heading"><div><span class="income-directory-kicker text-success">Choose a report</span><h2>Income Directory</h2></div><p>Every card opens the selected report directly.</p></div>
  <section class="income-directory-grid" aria-label="Income reports">
    @foreach($reports as $report)
      <a class="income-report-card" href="{{ route($report['route']) }}">
        <span class="income-report-card-icon"><i class="fa {{ $report['icon'] }}" aria-hidden="true"></i></span>
        <span><h3>{{ $report['title'] }}</h3><p>{{ $report['description'] }}</p></span>
        <i class="fa fa-chevron-right income-report-card-arrow" aria-hidden="true"></i>
      </a>
    @endforeach
  </section>
</main>
@endsection
