@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

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
  padding:10px 24px;
  font-weight:700;
  border:0;
}
.btn-main:hover{background:var(--dark);color:#fff}

.btn-gold{
  background:var(--gold);
  color:#fff;
  border-radius:30px;
  padding:10px 24px;
  font-weight:700;
  border:0;
}
.btn-gold:hover{background:#b88b22;color:#fff}

.hero{
  background:
  linear-gradient(rgba(123,30,58,.84),rgba(123,30,58,.84)),
  url('https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  padding:100px 0;
  color:#fff;
  text-align:center;
}

.hero h1{font-size:48px;font-weight:900}
.section-padding{padding:70px 0}
.section-title{color:var(--primary);font-weight:900;margin-bottom:12px}
.sub-title{color:#666;max-width:760px;margin:0 auto 45px}
.soft-bg{background:var(--cream)}

.search-box{
  background:#fff;
  border-radius:24px;
  padding:25px;
  margin-top:-45px;
  position:relative;
  z-index:5;
  box-shadow:0 12px 35px rgba(0,0,0,.12);
}

.form-control,.form-select{
  height:48px;
  border-radius:14px;
}

.category-btn{
  border:1px solid var(--primary);
  color:var(--primary);
  border-radius:30px;
  padding:8px 18px;
  font-weight:700;
  background:#fff;
  margin:5px;
}

.category-btn.active,
.category-btn:hover{
  background:var(--primary);
  color:#fff;
}

.product-card{
  background:#fff;
  border-radius:24px;
  overflow:hidden;
  height:100%;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
  border:1px solid #f1e2e8;
  transition:.3s;
}

.product-card:hover{
  transform:translateY(-8px);
  box-shadow:0 18px 45px rgba(123,30,58,.18);
}

.product-img{
  width:100%;
  height:230px;
  object-fit:cover;
  background:var(--light);
}

.product-

.badge-category{
  background:var(--light);
  color:var(--primary);
  padding:7px 14px;
  border-radius:30px;
  font-size:12px;
  font-weight:800;
}

.product-body h5{
  color:var(--primary);
  font-weight:900;
  margin-top:14px;
  min-height:48px;
}

.product-body p{
  color:#666;
  font-size:14px;
  min-height:42px;
}

.benefit-card{
  background:#fff;
  border-radius:22px;
  padding:28px;
  height:100%;
  text-align:center;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
  border:1px solid #f1e2e8;
}

.icon-box{
  width:70px;
  height:70px;
  background:var(--light);
  color:var(--primary);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:30px;
  margin:0 auto 18px;
}

.catalogue-box{
  background:
  linear-gradient(rgba(93,22,48,.92),rgba(93,22,48,.92)),
  url('https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
  border-radius:30px;
  padding:45px;
}

.cta{
  background:
  linear-gradient(rgba(123,30,58,.90),rgba(123,30,58,.90)),
  url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
  text-align:center;
  padding:80px 0;
}

footer{
  background:var(--dark);
  color:#fff;
  padding:25px 0;
}

@media(max-width:768px){
  .hero h1{font-size:34px}
  .section-padding{padding:55px 0}
  .search-box{margin-top:-25px;padding:18px}
  .product-img{height:190px}
  .catalogue-box{padding:30px 20px;text-align:center}
}
</style>
@endpush

@section('content')

@endsection
