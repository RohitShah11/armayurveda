@extends('layouts.front')

@push('styles')
<style>
.home-slider{background:#eef4e9;overflow:hidden}
.home-slider .carousel-item{background:#eef4e9}
.home-slider .carousel-item img{display:block;width:100%;height:auto;aspect-ratio:1.875/1;object-fit:contain}
.home-slider .carousel-control-prev,.home-slider .carousel-control-next{width:7%}
.home-slider .carousel-control-prev-icon,.home-slider .carousel-control-next-icon{width:46px;height:46px;background-color:rgba(27,94,32,.82);background-size:52%;border-radius:50%;box-shadow:0 4px 16px rgba(0,0,0,.2)}
.home-slider .carousel-indicators{margin-bottom:1rem}
.home-slider .carousel-indicators [data-bs-target]{width:11px;height:11px;border:2px solid #fff;border-radius:50%;background-color:var(--primary);box-shadow:0 2px 7px rgba(0,0,0,.35)}
.home-contact{position:relative;overflow:hidden;padding:78px 0;background:linear-gradient(135deg,#f4f9f3 0%,#fff 58%,#fff8e9 100%)}
.home-contact:before{content:"";position:absolute;left:-120px;bottom:-160px;width:330px;height:330px;border:55px solid rgba(46,125,50,.045);border-radius:50%}
.home-contact-shell{position:relative;display:grid;grid-template-columns:minmax(0,.78fr) minmax(0,1.22fr);overflow:hidden;border:1px solid #deeadf;border-radius:28px;background:#fff;box-shadow:0 22px 60px rgba(18,76,35,.11)}
.home-contact-intro{position:relative;isolation:isolate;display:flex;flex-direction:column;justify-content:center;min-height:420px;padding:48px;background:linear-gradient(145deg,rgba(3,75,32,.97),rgba(16,108,51,.92)),url('{{ asset('images/p4.jpeg') }}') center/cover no-repeat;color:#fff}
.home-contact-intro:after{content:"";position:absolute;z-index:-1;right:-80px;top:-75px;width:210px;height:210px;border:38px solid rgba(255,255,255,.055);border-radius:50%}
.home-contact-logo{width:92px;height:92px;margin-bottom:25px;padding:7px;border-radius:18px;background:#fff;object-fit:contain}
.home-contact-kicker{margin-bottom:9px;color:#f2c458;font-size:12px;font-weight:900;letter-spacing:.15em;text-transform:uppercase}
.home-contact-intro h2{margin:0 0 14px;font-size:clamp(32px,4vw,45px);line-height:1.08;font-weight:900}
.home-contact-intro p{max-width:420px;margin:0;color:rgba(255,255,255,.8);font-size:15px;line-height:1.75}
.home-contact-link{display:inline-flex;align-items:center;gap:9px;align-self:flex-start;margin-top:26px;padding:11px 19px;border-radius:999px;background:#dca11d;color:#fff;text-decoration:none;font-weight:800;transition:.2s}
.home-contact-link:hover{transform:translateY(-2px);background:#c58f16;color:#fff}
.home-contact-details{display:flex;flex-direction:column;justify-content:center;padding:44px}
.home-contact-details h3{margin:0 0 8px;color:#174524;font-size:25px;font-weight:900}
.home-contact-details>p{margin:0 0 25px;color:#6a776e;line-height:1.65}
.home-contact-list{display:grid;gap:13px}
.home-contact-item{display:flex;align-items:center;gap:16px;padding:17px 18px;border:1px solid #e2eae3;border-radius:17px;background:#fbfdfb;text-decoration:none;transition:.22s}
.home-contact-item:hover{transform:translateX(4px);border-color:#b8d5be;background:#f3f9f3;box-shadow:0 8px 20px rgba(18,76,35,.07)}
.home-contact-icon{display:grid;place-items:center;flex:0 0 48px;height:48px;border-radius:14px;background:#e9f5eb;color:#237b37;font-size:19px}
.home-contact-copy small{display:block;margin-bottom:2px;color:#839087;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
.home-contact-copy strong{display:block;color:#183b23;font-size:14px;line-height:1.45}
.home-contact-arrow{margin-left:auto;color:#3d854d}
@media(max-width:575.98px){
  .home-slider .carousel-control-prev,.home-slider .carousel-control-next{width:11%}
  .home-slider .carousel-control-prev-icon,.home-slider .carousel-control-next-icon{width:32px;height:32px}
  .home-slider .carousel-indicators{margin-bottom:.35rem}
  .home-slider .carousel-indicators [data-bs-target]{width:8px;height:8px}
}
@media(max-width:991.98px){.home-contact-shell{grid-template-columns:1fr}.home-contact-intro{min-height:auto;padding:38px}.home-contact-details{padding:38px}}
@media(max-width:575.98px){.home-contact{padding:55px 0}.home-contact-shell{border-radius:22px}.home-contact-intro,.home-contact-details{padding:28px 22px}.home-contact-logo{width:78px;height:78px}.home-contact-item{align-items:flex-start;padding:15px 13px}.home-contact-icon{flex-basis:43px;height:43px}.home-contact-copy strong{font-size:13px}.home-contact-arrow{display:none}}
</style>
@endpush

@section('content')
<section class="home-slider" aria-label="ARM Ayurveda highlights">
  <div id="homeHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover" data-bs-touch="true">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Ayurveda products"></button>
      <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="1" aria-label="Repurchase benefits"></button>
      <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="2" aria-label="Recharge cashback"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('images/home-slider-1.png') }}" alt="ARM Ayurveda products and wellness opportunities" fetchpriority="high">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/home-slider-2.png') }}" alt="ARM Ayurveda repurchase benefits" loading="lazy">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/home-slider-3.png') }}" alt="ARM Ayurveda mobile and DTH recharge cashback" loading="lazy">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous slide</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next slide</span>
    </button>
  </div>
</section>

<section class="container">
  <div class="trust-box">
    <div class="row g-3">
      <div class="col-lg-3 col-6 trust-item">
        <i class="fa fa-leaf"></i>
        <div><b>100% Natural</b><br>Pure Ayurvedic Ingredients</div>
      </div>
      <div class="col-lg-3 col-6 trust-item">
        <i class="fa fa-shield-halved"></i>
        <div><b>Trusted Quality</b><br>Best Standards & Safe Products</div>
      </div>
      <div class="col-lg-3 col-6 trust-item">
        <i class="fa fa-people-group"></i>
        <div><b>Business Opportunity</b><br>Grow Your Income With Us</div>
      </div>
      <div class="col-lg-3 col-6 trust-item">
        <i class="fa fa-headset"></i>
        <div><b>Support Always</b><br>We Are Here For You</div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title">OUR PRODUCT CATEGORIES</h2>
    <div class="title-line">Explore our wide range of natural and Ayurvedic products.</div>

    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="images/p1.jpeg">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-spa"></i></div>
            <h5>AYURVEDIC CARE</h5>
            <p>Traditional wellness products</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="images/p2.jpeg">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-bottle-droplet"></i></div>
            <h5>PERSONAL CARE</h5>
            <p>Natural care for healthy life</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="images/p4.jpeg">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-seedling"></i></div>
            <h5>HERBAL PRODUCTS</h5>
            <p>Pure herbal solutions</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="images/p3.jpeg">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-mortar-pestle"></i></div>
            <h5>DAILY WELLNESS</h5>
            <p>Products for your daily wellness</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5" style="background:#f7fbf3;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="section-title mb-0">FEATURED PRODUCTS</h2>
      <a href="{{route('products')}}" class="btn btn-outline-success rounded-pill">VIEW ALL PRODUCTS <i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="images/p7.jpeg">
          <div class="product-body">
            <h5>Herbal Face Care</h5>
            <p>Natural care for daily use</p>
            <div class="price">₹499</div>
            <!--<a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>-->
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="images/p5.jpeg">
          <div class="product-body">
            <h5>Ayurvedic Oil</h5>
            <p>Herbal oil for wellness</p>
            <div class="price">₹699</div>
            <!--<a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>-->
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="images/p4.jpeg">
          <div class="product-body">
            <h5>Herbal Supplement</h5>
            <p>Daily wellness support</p>
            <div class="price">₹999</div>
            <!--<a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>-->
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="images/p6.jpeg">
          <div class="product-body">
            <h5>Body Care Product</h5>
            <p>Natural personal care</p>
            <div class="price">₹599</div>
            <!--<a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="business">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-4">
        <h2>START YOUR BUSINESS <br><span>WITH ARM AYURVEDA</span></h2>
        <p>Simple product-based earning opportunity for dedicated and hardworking people.</p>
        <a href="{{route('register')}}" class="btn btn-light rounded-pill px-4">JOIN NOW <i class="fa fa-user-plus"></i></a>
      </div>

      <div class="col-lg-8">
        <div class="row g-4">
          <div class="col-md-3 col-6 step">
            <div class="step-circle"><i class="fa fa-user-plus"></i></div>
            <b>01<br>REGISTER</b>
            <p>Create your distributor account</p>
          </div>
          <div class="col-md-3 col-6 step">
            <div class="step-circle"><i class="fa fa-cart-shopping"></i></div>
            <b>02<br>PURCHASE</b>
            <p>Start with quality products</p>
          </div>
          <div class="col-md-3 col-6 step">
            <div class="step-circle"><i class="fa fa-bullhorn"></i></div>
            <b>03<br>SELL</b>
            <p>Share products with others</p>
          </div>
          <div class="col-md-3 col-6 step">
            <div class="step-circle"><i class="fa fa-chart-line"></i></div>
            <b>04<br>GROW</b>
            <p>Build income and strong team</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="home-contact">
  <div class="container">
    <div class="home-contact-shell">
      <div class="home-contact-intro">
        <img src="{{ asset('images/arm-ayurveda-logo.png') }}" class="home-contact-logo" alt="ARM Ayurveda">
        <div class="home-contact-kicker">Get in touch</div>
        <h2>We’re here to support your wellness journey.</h2>
        <p>For product enquiries, feedback, distributor assistance or business support, connect with the ARM Ayurveda team.</p>
        <a href="{{ route('contact') }}" class="home-contact-link">Contact our team <i class="fa-solid fa-arrow-right"></i></a>
      </div>

      <div class="home-contact-details">
        <h3>Choose the easiest way to reach us</h3>
        <p>Our support team is available Monday to Saturday, from 10:00 AM to 6:00 PM.</p>
        <div class="home-contact-list">
          <a href="tel:+919242068805" class="home-contact-item">
            <span class="home-contact-icon"><i class="fa-solid fa-phone-volume"></i></span>
            <span class="home-contact-copy"><small>Call us</small><strong>+91 92420 68805</strong></span>
            <i class="fa-solid fa-arrow-right home-contact-arrow"></i>
          </a>
          <a href="mailto:armayurveda@gmail.com" class="home-contact-item">
            <span class="home-contact-icon"><i class="fa-regular fa-envelope"></i></span>
            <span class="home-contact-copy"><small>Email us</small><strong>armayurveda@gmail.com</strong></span>
            <i class="fa-solid fa-arrow-right home-contact-arrow"></i>
          </a>
          <a href="{{ route('contact') }}#location" class="home-contact-item">
            <span class="home-contact-icon"><i class="fa-solid fa-location-dot"></i></span>
            <span class="home-contact-copy"><small>Visit us</small><strong>Ashoknagar, North 24 Parganas, West Bengal</strong></span>
            <i class="fa-solid fa-arrow-right home-contact-arrow"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
