@extends('layouts.app')

@section('title', 'Contactus')
@section('page-title', 'Contactus')

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

.contact-card{
  background:#fff;
  border-radius:24px;
  padding:30px;
  height:100%;
  box-shadow:0 12px 35px rgba(0,0,0,.08);
  border:1px solid #f1e2e8;
  text-align:center;
}

.contact-icon{
  width:75px;
  height:75px;
  background:var(--light);
  color:var(--primary);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:32px;
  margin:0 auto 18px;
}

.contact-card h5{
  color:var(--primary);
  font-weight:900;
}

.form-box{
  background:#fff;
  border-radius:28px;
  padding:40px;
  box-shadow:0 12px 35px rgba(0,0,0,.10);
  border:1px solid #f1e2e8;
}

.form-control,.form-select{
  height:50px;
  border-radius:14px;
}

textarea.form-control{
  height:130px;
}

.info-box{
  background:
  linear-gradient(rgba(93,22,48,.92),rgba(93,22,48,.92)),
  url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
  border-radius:28px;
  padding:40px;
  height:100%;
}

.info-box img{
  width:170px;
  background:#fff;
  padding:10px;
  border-radius:16px;
  margin-bottom:25px;
}

.info-list{
  list-style:none;
  padding:0;
  margin:0;
}

.info-list li{
  display:flex;
  gap:14px;
  margin-bottom:18px;
  align-items:flex-start;
}

.info-list i{
  color:var(--gold);
  font-size:22px;
  margin-top:3px;
}

.map-box{
  border-radius:28px;
  overflow:hidden;
  box-shadow:0 12px 35px rgba(0,0,0,.10);
}

.map-box iframe{
  width:100%;
  height:420px;
  border:0;
}

.quick-card{
  background:#fff;
  border-radius:22px;
  padding:28px;
  height:100%;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
  border:1px solid #f1e2e8;
}

.quick-card i{
  color:var(--primary);
  font-size:34px;
  margin-bottom:15px;
}

.cta{
  background:
  linear-gradient(rgba(123,30,58,.90),rgba(123,30,58,.90)),
  url('https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?auto=format&fit=crop&w=1600&q=80');
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
  .form-box,.info-box{padding:28px 20px}
  .map-box iframe{height:320px}
}
</style>
@endpush

@section('content')

@endsection
