@extends('layouts.app')

@section('title', 'Gellery')
@section('page-title', 'Gellery')

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
  url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80');
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

.filter-btn{
  border:1px solid var(--primary);
  color:var(--primary);
  background:#fff;
  border-radius:30px;
  padding:9px 20px;
  font-weight:700;
  margin:5px;
}
.filter-btn.active,
.filter-btn:hover{
  background:var(--primary);
  color:#fff;
}

.gallery-card{
  position:relative;
  overflow:hidden;
  border-radius:24px;
  box-shadow:0 12px 35px rgba(0,0,0,.10);
  height:280px;
  cursor:pointer;
}

.gallery-card.large{height:585px}

.gallery-card img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:.4s;
}

.gallery-card:hover img{
  transform:scale(1.08);
}

.gallery-overlay{
  position:absolute;
  inset:0;
  background:linear-gradient(to top,rgba(93,22,48,.85),rgba(93,22,48,.10));
  color:#fff;
  display:flex;
  flex-direction:column;
  justify-content:end;
  padding:24px;
  opacity:.95;
}

.gallery-overlay h5{
  font-weight:900;
}

.video-card{
  background:#fff;
  border-radius:24px;
  overflow:hidden;
  box-shadow:0 12px 35px rgba(0,0,0,.10);
  height:100%;
}

.video-thumb{
  position:relative;
  height:250px;
  overflow:hidden;
}

.video-thumb img{
  width:100%;
  height:100%;
  object-fit:cover;
}

.play-btn{
  position:absolute;
  left:50%;
  top:50%;
  transform:translate(-50%,-50%);
  width:70px;
  height:70px;
  background:var(--gold);
  color:#fff;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:28px;
}

.video-

.video-body h5{
  color:var(--primary);
  font-weight:900;
}

.event-card{
  background:#fff;
  border-radius:24px;
  padding:25px;
  box-shadow:0 12px 35px rgba(0,0,0,.08);
  border:1px solid #f1e2e8;
  height:100%;
}

.event-icon{
  width:70px;
  height:70px;
  background:var(--light);
  color:var(--primary);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:30px;
  margin-bottom:18px;
}

.cta{
  background:
  linear-gradient(rgba(123,30,58,.90),rgba(123,30,58,.90)),
  url('https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=1600&q=80');
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
  .gallery-card,.gallery-card.large{height:260px}
}
</style>
@endpush

@section('content')

@endsection
