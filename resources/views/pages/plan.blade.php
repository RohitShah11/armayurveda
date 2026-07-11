@extends('layouts.app')

@section('title', 'Plan')
@section('page-title', 'Plan')

@push('styles')
<style>
.logo{width:125px}
.navbar{padding:16px 0}
.nav-link{font-weight:700;font-size:14px;margin:0 12px;color:#111}
.nav-link.active,.nav-link:hover{color:var(--primary)}

.btn-main{
  background:var(--primary);
  color:#fff;
  border-radius:30px;
  padding:11px 28px;
  font-weight:700;
  border:0;
}
.btn-main:hover{background:var(--dark);color:#fff}

.btn-gold{
  background:var(--gold);
  color:#fff;
  border-radius:30px;
  padding:11px 28px;
  font-weight:700;
  border:0;
}
.btn-gold:hover{background:#b88b22;color:#fff}

.hero{
  background:
  linear-gradient(rgba(123,30,58,.84),rgba(123,30,58,.84)),
  url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  padding:100px 0;
  color:#fff;
  text-align:center;
}

.hero h1{font-size:48px;font-weight:900}
.section-padding{padding:75px 0}
.section-title{color:var(--primary);font-weight:900;margin-bottom:12px}
.sub-title{color:#666;max-width:760px;margin:0 auto 45px}

.soft-bg{background:var(--cream)}

.card-box{
  background:#fff;
  border-radius:22px;
  padding:28px;
  height:100%;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
  border:1px solid #f1e2e8;
}

.icon-box{
  width:68px;
  height:68px;
  border-radius:50%;
  background:var(--light);
  color:var(--primary);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:28px;
  margin-bottom:18px;
}

.plan-card{
  background:#fff;
  border-radius:25px;
  overflow:hidden;
  box-shadow:0 12px 35px rgba(0,0,0,.10);
  border:1px solid #f1e2e8;
  height:100%;
}

.plan-header{
  background:var(--primary);
  color:#fff;
  padding:25px;
  text-align:center;
}

.plan-header h3{font-weight:900}
.plan-
.plan-body ul{padding-left:0;list-style:none}
.plan-body li{margin-bottom:12px}
.plan-body li i{color:var(--primary);margin-right:8px}

.income-table{
  border-radius:18px;
  overflow:hidden;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
}
.table thead th{
  background:var(--primary);
  color:#fff;
}
.table td,.table th{padding:16px}

.process{
  background:
  linear-gradient(rgba(93,22,48,.92),rgba(93,22,48,.92)),
  url('https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
}

.step-card{
  background:rgba(255,255,255,.12);
  border:1px solid rgba(255,255,255,.25);
  border-radius:22px;
  padding:30px;
  height:100%;
  text-align:center;
}
.step-card h2{color:var(--gold);font-weight:900}

.download-box{
  background:var(--primary);
  color:#fff;
  border-radius:28px;
  padding:45px;
}

.faq .accordion-button:not(.collapsed){
  background:var(--light);
  color:var(--primary);
  font-weight:700;
}

footer{
  background:var(--dark);
  color:#fff;
  padding:25px 0;
}

@media(max-width:768px){
  .hero h1{font-size:34px}
  .section-padding{padding:55px 0}
  .download-box{padding:30px 20px;text-align:center}
}
</style>
@endpush

@section('content')

@endsection
