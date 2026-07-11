@extends('layouts.app')

@section('title', 'About_Us')
@section('page-title', 'About_Us')

@push('styles')
<style>
.logo{
  width:125px;
}

.navbar{
  padding:16px 0;
}

.nav-link{
  font-weight:700;
  font-size:14px;
  margin:0 12px;
  color:#111;
}

.nav-link.active,
.nav-link:hover{
  color:var(--primary);
}

.btn-main{
  background:var(--primary);
  color:#fff;
  border-radius:30px;
  padding:11px 28px;
  font-weight:700;
  border:0;
}

.btn-main:hover{
  background:var(--dark);
  color:#fff;
}

.btn-gold{
  background:var(--gold);
  color:#fff;
  border-radius:30px;
  padding:11px 28px;
  font-weight:700;
  border:0;
}

.hero{
  background:
  linear-gradient(rgba(123,30,58,.80),rgba(123,30,58,.80)),
  url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  padding:100px 0;
  color:#fff;
  text-align:center;
}

.hero h1{
  font-size:48px;
  font-weight:900;
}

.section-padding{
  padding:75px 0;
}

.section-title{
  color:var(--primary);
  font-weight:900;
  margin-bottom:15px;
}

.sub-title{
  color:#666;
  max-width:720px;
  margin:0 auto 45px;
}

.about-img{
  width:100%;
  height:430px;
  object-fit:cover;
  border-radius:25px;
  box-shadow:0 15px 40px rgba(0,0,0,.12);
}

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

.soft-bg{
  background:var(--cream);
}

.mission-card{
  background:#fff;
  border-left:6px solid var(--primary);
  border-radius:18px;
  padding:30px;
  height:100%;
  box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.timeline{
  position:relative;
}

.timeline::before{
  content:"";
  position:absolute;
  left:50%;
  top:0;
  bottom:0;
  width:4px;
  background:var(--gold);
  transform:translateX(-50%);
}

.timeline-item{
  position:relative;
  margin-bottom:35px;
}

.timeline-content{
  background:#fff;
  padding:24px;
  border-radius:18px;
  box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.timeline-number{
  width:52px;
  height:52px;
  background:var(--primary);
  color:#fff;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:900;
  position:absolute;
  left:50%;
  top:15px;
  transform:translateX(-50%);
  z-index:2;
}

.director{
  background:
  linear-gradient(rgba(93,22,48,.90),rgba(93,22,48,.90)),
  url('https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
}

.director-img{
  width:100%;
  height:400px;
  object-fit:cover;
  border-radius:25px;
}

.category-card{
  border-radius:24px;
  overflow:hidden;
  background:#fff;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
  height:100%;
}

.category-card img{
  width:100%;
  height:210px;
  object-fit:cover;
}

.category-card div{
  padding:22px;
  text-align:center;
}

.category-card h5{
  color:var(--primary);
  font-weight:900;
}

.stats{
  background:var(--primary);
  color:#fff;
}

.stat-box{
  text-align:center;
}

.stat-box h2{
  font-size:42px;
  font-weight:900;
  color:var(--gold);
}

.gallery-img{
  width:100%;
  height:260px;
  object-fit:cover;
  border-radius:22px;
  box-shadow:0 8px 25px rgba(0,0,0,.10);
}

.cta{
  background:
  linear-gradient(rgba(123,30,58,.88),rgba(123,30,58,.88)),
  url('https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
  text-align:center;
  padding:80px 0;
}

.contact-section{
  background:var(--cream);
}

.form-control{
  height:48px;
  border-radius:12px;
}

textarea.form-control{
  height:110px;
}

footer{
  background:var(--dark);
  color:#fff;
  padding:25px 0;
}

@media(max-width:768px){
  .hero h1{font-size:34px}
  .section-padding{padding:55px 0}
  .timeline::before{left:20px}
  .timeline-number{left:20px}
  .timeline-content{margin-left:50px}
  .about-img,.director-img{height:300px}
}
</style>
@endpush

@section('content')

@endsection
