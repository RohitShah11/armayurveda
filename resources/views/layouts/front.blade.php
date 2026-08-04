<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'ARM Ayurveda Pvt. Ltd.')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --primary:#2E7D32;
      --dark:#1B5E20;
      --gold:#dca11d;
      --light:#F1F8E9;
      --cream:#f7fbf3;
      --text:#102d17;
    }

    body{font-family:Arial,sans-serif;color:#102d17;background:#fff}
    .topbar{background:#00551f;color:#fff;font-size:14px;padding:7px 0}
    .navbar{padding:18px 0}
    .logo{width:125px}
    .nav-link{font-weight:700;font-size:14px;margin:0 14px;color:#111}
    .nav-link.active{color:var(--primary);border-bottom:2px solid var(--primary)}
    .btn-green{background:var(--primary);color:#fff;border-radius:25px;padding:10px 25px;font-weight:700;border:0}
    .btn-green:hover{background:var(--dark);color:#fff}
    .btn-gold{background:#dca11d;color:#fff;border-radius:25px;padding:10px 25px;font-weight:700;border:0}
    .hero{background:url('https://armayurveda.com/public/images/banner.png') center/cover no-repeat;padding:70px 0}
    .hero-logo{width:210px}
    .hero h1{font-size:52px;font-weight:900;color:#064719}
    .hero h3{font-size:32px;font-weight:700;color:#111}
    .hero p{font-size:18px;max-width:500px}
    .trust-box{background:#f3f7ef;border-radius:12px;padding:24px 20px;margin-top:35px}
    .trust-item{display:flex;align-items:center;gap:15px;border-right:1px solid #d8ded2}
    .trust-item:last-child{border-right:0}
    .trust-item i{font-size:42px;color:var(--primary)}
    .section-title{text-align:center;color:#064719;font-weight:900;margin-bottom:10px}
    .title-line{text-align:center;color:#2b7b25;margin-bottom:30px}
    .category-card,.product-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,.09);height:100%}
    .category-card img,.product-card img{width:100%;height:170px;object-fit:cover}
    .category-body,.product-body{text-align:center;padding:22px}
    .circle-icon{width:65px;height:65px;background:#1e7b2b;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:-50px auto 15px;font-size:28px;border:5px solid #fff;position:relative}
    .product-body h5,.category-body h5{color:#064719;font-weight:800}
    .price{font-size:24px;font-weight:900;color:#0b641f}
    .business{background:var(--primary);color:#fff;padding:45px 0}
    .business h2{font-weight:900}
    .business h2 span{color:#dca11d}
    .step{text-align:center}
    .step-circle{width:90px;height:90px;background:#fff;color:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;font-size:34px}
    .contact{background:#f7fbf3;padding:45px 0}
    .contact-logo{width:210px}
    .form-control{height:45px;border-radius:4px}
    textarea.form-control{height:100px}
    footer{background:var(--primary);color:#fff;padding:16px 0;font-size:14px}
    @media(max-width:768px){
      .hero{text-align:center;padding:45px 0}
      .hero h1{font-size:34px}
      .hero h3{font-size:22px}
      .hero-logo{width:160px;margin-bottom:20px}
      .trust-item{border-right:0;border-bottom:1px solid #d8ded2;padding:15px 0}
      .business{text-align:center}
      .logo{width:100px}
    }


    body{font-family:Arial,sans-serif;color:var(--text);background:#fff}
    .topbar{background:var(--primary);color:#fff;padding:8px 0;font-size:14px}
    .logo{width:50px}
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
      linear-gradient(rgba(46,125,50,.84),rgba(46,125,50,.84)),
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
    .plan-body{padding:28px}
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
      linear-gradient(rgba(27,94,32,.92),rgba(27,94,32,.92)),
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
      background:var(--primary);
      color:#fff;
      padding:25px 0;
      display:block;
    }

    @media(max-width:768px){
      .hero h1{font-size:34px}
      .section-padding{padding:55px 0}
      .download-box{padding:30px 20px;text-align:center}
    }

    
.topbar{
  background:var(--primary);
  color:#fff;
  padding:8px 0;
  font-size:14px;
}

.logo{
  width:50x;
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
  url('https://armayurveda.com/public/images/banner.png');
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
  linear-gradient(rgba(27,94,32,.90),rgba(27,94,32,.90)),
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
  linear-gradient(rgba(46,125,50,.88),rgba(46,125,50,.88)),
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
  background:linear-gradient(to top,rgba(27,94,32,.85),rgba(27,94,32,.10));
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

.video-body{
  padding:22px;
}

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
  linear-gradient(rgba(46,125,50,.90),rgba(46,125,50,.90)),
  url('https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=1600&q=80');
  background-size:cover;
  background-position:center;
  color:#fff;
  text-align:center;
  padding:80px 0;
}


  </style>
  @stack('styles')
</head>

<body>

<div class="topbar">
  <div class="container d-flex justify-content-between flex-wrap">
    <span>Welcome to ARM Ayurveda Pvt. Ltd.</span>
    <span><i class="fa fa-phone"></i> +91 70851 70022 &nbsp;&nbsp; <i class="fa fa-envelope"></i> armayurveda@gmail.com</span>
  </div>
</div>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="images/logo.jpeg" class="logo" alt="ARM Ayurveda">
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto align-items-lg-center">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">
                    HOME
                </a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                    ABOUT US
                </a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">
                    PRODUCTS
                </a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('plan') ? 'active' : '' }}" href="{{ route('plan') }}">
                    BUSINESS PLAN
                </a>
            </li>
    
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">
                    GALLERY
                </a>
            </li> --}}
    
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                    CONTACT US
                </a>
            </li>
    
            <li class="nav-item ms-lg-3">
                <a class="btn btn-green" href="{{ route('login') }}">
                    <i class="fa fa-users"></i> JOIN NOW
                </a>
            </li>
        </ul>
    </div>
  </div>
</nav>

@yield('content')

<footer>
  <div class="container d-flex justify-content-between flex-wrap">
    <span>© 2026 ARM Ayurveda Pvt. Ltd. All Rights Reserved.</span>
    <span>Privacy Policy &nbsp; | &nbsp; Terms & Conditions</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
