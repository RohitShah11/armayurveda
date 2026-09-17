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
    .logo{width:80px}
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


    .topbar{background:#174d2b;padding:12px 0;color:#fff;font-size:13px;border-bottom:2px solid var(--gold)}
    .topbar-inner{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px 24px}
    .topbar-welcome{display:flex;align-items:center;gap:10px;font-weight:600}
    .topbar-welcome i{color:#f0c76a}
    .topbar-details{display:flex;align-items:center;flex-wrap:wrap;gap:12px 20px}
    .topbar-link{display:inline-flex;align-items:center;gap:8px;color:#fff;text-decoration:none;white-space:nowrap}
    .topbar-link i{color:#f0c76a;font-size:12px}
    .topbar-link:hover{color:#f0c76a;text-decoration:underline;text-underline-offset:4px}
    .topbar-link:focus-visible{outline:2px solid #f0c76a;outline-offset:5px;border-radius:3px}
    .topbar-gst{display:inline-flex;align-items:center;gap:7px;padding:5px 10px;border:1px solid rgba(240,199,106,.5);border-radius:6px;background:rgba(255,255,255,.06);white-space:nowrap;font-size:12px;letter-spacing:.2px}
    .topbar-gst strong{color:#f0c76a;font-weight:700}
    @media(max-width:1199px){
      .topbar-inner{justify-content:center}
      .topbar-details{justify-content:center}
    }
    @media(max-width:575px){
      .topbar{padding:12px 0;font-size:12px}
      .topbar-inner{gap:10px}
      .topbar-welcome{justify-content:center;text-align:center}
      .topbar-details{width:100%;gap:10px 16px}
      .topbar-gst{font-size:11px}
    }
    .site-footer{background:#123e25;color:#dce8df;padding:0;border-top:3px solid var(--gold);font-size:14px}
    .footer-main{display:grid;grid-template-columns:1.4fr .8fr 1fr;gap:48px;padding-top:52px;padding-bottom:42px}
    .footer-brand{display:flex;align-items:center;gap:16px;margin-bottom:18px;color:#fff;text-decoration:none}
    .footer-logo{width:76px;height:76px;object-fit:contain;background:#fff;border-radius:16px;padding:8px;flex-shrink:0}
    .footer-brand-name{font-size:21px;font-weight:800;line-height:1.3}
    .footer-brand-name small{display:block;margin-top:4px;font-size:13px;font-weight:400;color:#c6d9cc}
    .footer-description{max-width:350px;margin:0 0 20px;line-height:1.8;color:#c6d9cc}
    .footer-gst{display:inline-flex;flex-wrap:wrap;gap:6px 9px;padding:10px 14px;border:1px solid rgba(240,199,106,.4);border-radius:8px;background:rgba(255,255,255,.04);font-size:13px}
    .footer-gst strong{color:#f0c76a}
    .footer-title{margin:4px 0 20px;color:#fff;font-size:16px;font-weight:700}
    .footer-links{list-style:none;padding:0;margin:0;display:grid;gap:12px}
    .site-footer a{color:#dce8df;text-decoration:none}
    .site-footer a:hover{color:#f0c76a}
    .site-footer a:focus-visible{outline:2px solid #f0c76a;outline-offset:5px;border-radius:3px}
    .footer-contact{display:grid;gap:16px;margin:0;font-style:normal}
    .footer-contact-item{display:flex;align-items:flex-start;gap:12px;line-height:1.7}
    .footer-contact-item i{width:16px;flex-shrink:0;margin-top:5px;color:#f0c76a}
    .footer-contact-item a{overflow-wrap:anywhere}
    .footer-bottom{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;padding-top:20px;padding-bottom:20px;border-top:1px solid rgba(255,255,255,.15);font-size:12px;color:#c6d9cc}
    .footer-bottom p{margin:0}
    .footer-bottom a{display:inline-flex;align-items:center;gap:8px}
    @media(max-width:991px){.footer-main{grid-template-columns:1fr 1fr;gap:32px}.footer-company{grid-column:1 / -1}.footer-description{max-width:520px}}
    @media(max-width:575px){.footer-main{grid-template-columns:1fr;gap:30px;padding-top:34px;padding-bottom:30px}.footer-company{grid-column:auto}.footer-brand-name{font-size:20px}.footer-links{grid-template-columns:1fr 1fr;gap:14px}.footer-bottom{align-items:flex-start;flex-direction:column;line-height:1.7}}
  </style>
  @stack('styles')
</head>

<body>

<div class="topbar">
  <div class="container topbar-inner">
    <span class="topbar-welcome"><i class="fa-solid fa-leaf" aria-hidden="true"></i> Welcome to ARM Ayurveda Pvt. Ltd.</span>
    <div class="topbar-details">
      <a class="topbar-link" href="tel:+919242068805"><i class="fa-solid fa-phone" aria-hidden="true"></i> +91 92420 68805</a>
      <a class="topbar-link" href="mailto:armayurveda@gmail.com"><i class="fa-solid fa-envelope" aria-hidden="true"></i> armayurveda@gmail.com</a>
      <span class="topbar-gst"><strong>GST No:</strong> 19ABFCA8774N1ZS</span>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="images/logo.png" class="logo" alt="ARM Ayurveda">
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

<footer class="site-footer">
  <div class="container footer-main">
    <div class="footer-company">
      <a class="footer-brand" href="{{ route('index') }}">
        <img class="footer-logo" src="{{ asset('images/logo.png') }}" alt="" width="76" height="76" loading="lazy">
        <span class="footer-brand-name">ARM Ayurveda<small>Private Limited</small></span>
      </a>
      <p class="footer-description">Discover our Ayurvedic products and connect with a community that shares your passion for everyday wellness.</p>
      <div class="footer-gst"><strong>GST No:</strong> <span class="text-nowrap">19ABFCA8774N1ZS</span></div>
    </div>
    <nav aria-label="Footer navigation">
      <h2 class="footer-title">Explore</h2>
      <ul class="footer-links">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('products') }}">Our Products</a></li>
        <li><a href="{{ route('plan') }}">Business Plan</a></li>
        <li><a href="{{ route('contact') }}">Contact Us</a></li>
      </ul>
    </nav>
    <div>
      <h2 class="footer-title">Get in touch</h2>
      <address class="footer-contact">
        <div class="footer-contact-item"><i class="fa-solid fa-phone" aria-hidden="true"></i><a href="tel:+919242068805">+91 92420 68805</a></div>
        <div class="footer-contact-item"><i class="fa-solid fa-envelope" aria-hidden="true"></i><a href="mailto:armayurveda@gmail.com">armayurveda@gmail.com</a></div>
        <div class="footer-contact-item"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>Ashoknagar, North 24 Parganas,<br>West Bengal, India</span></div>
      </address>
    </div>
  </div>
  <div class="container footer-bottom">
    <p>© {{ date('Y') }} ARM Ayurveda Pvt. Ltd. All Rights Reserved.</p>
    <a href="{{ route('login') }}">Member Login <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
