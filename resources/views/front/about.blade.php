@extends('layouts.front')
@push('styles')
<style>
.about-contact{position:relative;overflow:hidden;padding:78px 0;background:linear-gradient(135deg,#f3f9f3,#fff 62%,#fff8e8)}
.about-contact:before{content:"";position:absolute;right:-110px;bottom:-150px;width:320px;height:320px;border:52px solid rgba(46,125,50,.045);border-radius:50%}
.about-contact-shell{position:relative;display:grid;grid-template-columns:minmax(0,.8fr) minmax(0,1.2fr);overflow:hidden;border:1px solid #deeadf;border-radius:28px;background:#fff;box-shadow:0 22px 60px rgba(18,76,35,.11)}
.about-contact-intro{position:relative;isolation:isolate;display:flex;flex-direction:column;justify-content:center;min-height:420px;padding:48px;background:linear-gradient(145deg,rgba(3,75,32,.97),rgba(16,108,51,.92)),url('{{ asset('images/p5.jpeg') }}') center/cover no-repeat;color:#fff}
.about-contact-intro:after{content:"";position:absolute;z-index:-1;right:-80px;top:-75px;width:210px;height:210px;border:38px solid rgba(255,255,255,.055);border-radius:50%}
.about-contact-logo{width:92px;height:92px;margin-bottom:24px;padding:7px;border-radius:18px;background:#fff;object-fit:contain}
.about-contact-kicker{margin-bottom:9px;color:#f2c458;font-size:12px;font-weight:900;letter-spacing:.15em;text-transform:uppercase}
.about-contact-intro h2{margin:0 0 14px;font-size:clamp(32px,4vw,44px);line-height:1.08;font-weight:900}
.about-contact-intro p{max-width:420px;margin:0;color:rgba(255,255,255,.8);font-size:15px;line-height:1.75}
.about-contact-button{display:inline-flex;align-items:center;gap:9px;align-self:flex-start;margin-top:26px;padding:11px 19px;border-radius:999px;background:#dca11d;color:#fff;text-decoration:none;font-weight:800;transition:.2s}
.about-contact-button:hover{transform:translateY(-2px);background:#c58f16;color:#fff}
.about-contact-details{display:flex;flex-direction:column;justify-content:center;padding:44px}
.about-contact-details h3{margin:0 0 8px;color:#174524;font-size:25px;font-weight:900}
.about-contact-details>p{margin:0 0 25px;color:#6a776e;line-height:1.65}
.about-contact-list{display:grid;gap:13px}
.about-contact-item{display:flex;align-items:center;gap:16px;padding:17px 18px;border:1px solid #e2eae3;border-radius:17px;background:#fbfdfb;text-decoration:none;transition:.22s}
.about-contact-item:hover{transform:translateX(4px);border-color:#b8d5be;background:#f3f9f3;box-shadow:0 8px 20px rgba(18,76,35,.07)}
.about-contact-icon{display:grid;place-items:center;flex:0 0 48px;height:48px;border-radius:14px;background:#e9f5eb;color:#237b37;font-size:19px}
.about-contact-copy small{display:block;margin-bottom:2px;color:#839087;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
.about-contact-copy strong{display:block;color:#183b23;font-size:14px;line-height:1.45}
.about-contact-arrow{margin-left:auto;color:#3d854d}
@media (max-width:991.98px){.about-contact-shell{grid-template-columns:1fr}.about-contact-intro{min-height:auto;padding:38px}.about-contact-details{padding:38px}}
@media (max-width:575.98px){
  .about-page .container{padding-left:24px;padding-right:24px}
  .about-contact{padding:55px 0}.about-contact-shell{border-radius:22px}.about-contact-intro,.about-contact-details{padding:28px 22px}.about-contact-logo{width:78px;height:78px}.about-contact-item{align-items:flex-start;padding:15px 13px}.about-contact-icon{flex-basis:43px;height:43px}.about-contact-copy strong{font-size:13px}.about-contact-arrow{display:none}
}
</style>
@endpush
@section('content')

<div class="about-page">

<section class="hero">
  <div class="container">
    <h1>About ARM Ayurveda</h1>
    <p class="lead">Nature's Gift for Better Health</p>
    <p>Home / About Us</p>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6">
        <img src="https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=900&q=80" class="about-img">
      </div>

      <div class="col-lg-6">
        <h2 class="section-title">About ARM Ayurveda Pvt. Ltd.</h2>
        <p>
          ARM Ayurveda Pvt. Ltd. is committed to delivering premium Ayurvedic wellness products inspired by ancient Indian traditions and modern quality standards.
        </p>
        <p>
          Our mission is to improve lives through natural healthcare while creating sustainable business opportunities for individuals across India.
        </p>
        <p>
          We believe that good health begins with nature, purity, quality and trust.
        </p>
        <a href="{{route('products')}}" class="btn btn-main mt-3">Explore Products</a>
      </div>
    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container text-center">
    <h2 class="section-title">Our Vision & Mission</h2>
    <p class="sub-title">Building a healthier future with trusted Ayurveda and ethical business growth.</p>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="mission-card text-start">
          <div class="icon-box"><i class="fa fa-eye"></i></div>
          <h4>Our Vision</h4>
          <p>
            To become one of India's trusted Ayurvedic wellness brands by providing quality products and empowering entrepreneurs.
          </p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="mission-card text-start">
          <div class="icon-box"><i class="fa fa-bullseye"></i></div>
          <h4>Our Mission</h4>
          <p>
            To promote healthy living through authentic Ayurvedic products while creating a strong product-based business ecosystem.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container text-center">
    <h2 class="section-title">Our Core Values</h2>
    <p class="sub-title">The principles that guide ARM Ayurveda every day.</p>

    <div class="row g-4">
      <div class="col-lg-3 col-6">
        <div class="card-box text-center">
          <div class="icon-box mx-auto"><i class="fa fa-leaf"></i></div>
          <h5>Purity</h5>
          <p>Natural wellness inspired by Ayurveda.</p>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="card-box text-center">
          <div class="icon-box mx-auto"><i class="fa fa-handshake"></i></div>
          <h5>Trust</h5>
          <p>Long-term customer and partner trust.</p>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="card-box text-center">
          <div class="icon-box mx-auto"><i class="fa fa-flask"></i></div>
          <h5>Quality</h5>
          <p>Products selected with care and standards.</p>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="card-box text-center">
          <div class="icon-box mx-auto"><i class="fa fa-chart-line"></i></div>
          <h5>Growth</h5>
          <p>Business opportunity for dedicated people.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container">
    <div class="text-center">
      <h2 class="section-title">Our Journey</h2>
      <p class="sub-title">From idea to a growing Ayurveda business platform.</p>
    </div>

    <div class="timeline">
      <div class="timeline-item row">
        <div class="col-md-5">
          <div class="timeline-content">
            <h5>Company Started</h5>
            <p>ARM Ayurveda began with a vision to promote natural wellness and trusted products.</p>
          </div>
        </div>
        <div class="timeline-number">01</div>
        <div class="col-md-5 offset-md-2"></div>
      </div>

      <div class="timeline-item row">
        <div class="col-md-5"></div>
        <div class="timeline-number">02</div>
        <div class="col-md-5 offset-md-2">
          <div class="timeline-content">
            <h5>Product Development</h5>
            <p>Focused on creating a practical product range for health, care and daily wellness.</p>
          </div>
        </div>
      </div>

      <div class="timeline-item row">
        <div class="col-md-5">
          <div class="timeline-content">
            <h5>Distributor Network</h5>
            <p>Building a product-based opportunity for customers and business partners.</p>
          </div>
        </div>
        <div class="timeline-number">03</div>
        <div class="col-md-5 offset-md-2"></div>
      </div>

      <div class="timeline-item row">
        <div class="col-md-5"></div>
        <div class="timeline-number">04</div>
        <div class="col-md-5 offset-md-2">
          <div class="timeline-content">
            <h5>Growing Across India</h5>
            <p>Expanding with quality, support and long-term business commitment.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding director">
  <div class="container">
    <div class="row g-5 align-items-center mt-0">
      <div class="col-lg-5">
        <!--<img src="images/placeholder.webp" class="director-img">-->
      </div>

      <div class="col-lg-7">
        <h2 class="fw-bold">Director's Message</h2>
        <p class="lead">
          ARM Ayurveda believes that every family deserves natural healthcare.
        </p>
        <p>
          Our commitment is to provide trusted Ayurvedic products while helping people build successful product-based businesses.
        </p>
        <p>
          Together, we can create a healthier and stronger India.
        </p>
        <h5 class="mt-4">Director</h5>
        <p>ARM Ayurveda Pvt. Ltd.</p>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container text-center">
    <h2 class="section-title">Our Product Categories</h2>
    <p class="sub-title">A complete wellness range for modern Indian families.</p>

    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=700&q=80">
          <div>
            <h5>Healthcare</h5>
            <p>Ayurvedic health support products.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=700&q=80">
          <div>
            <h5>Personal Care</h5>
            <p>Natural personal care products.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="images/p8.jpeg">
          <div>
            <h5>Nutrition</h5>
            <p>Daily health and nutrition support.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="images/p9.jpeg">
          <div>
            <h5>Daily Wellness</h5>
            <p>Wellness products for daily lifestyle.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding stats">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-3 col-6 stat-box">
        <h2>20+</h2>
        <p>Products</p>
      </div>
      <div class="col-md-3 col-6 stat-box">
        <h2>1000+</h2>
        <p>Happy Customers</p>
      </div>
      <div class="col-md-3 col-6 stat-box">
        <h2>250+</h2>
        <p>Business Partners</p>
      </div>
      <div class="col-md-3 col-6 stat-box">
        <h2>10+</h2>
        <p>States Served</p>
      </div>
    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container text-center">
    <h2 class="section-title">Gallery</h2>
    <p class="sub-title">A premium Ayurveda brand experience.</p>

    <div class="row g-4">
      <div class="col-md-4">
        <img class="gallery-img" src="images/p1.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p2.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p3.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p4.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p5.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p6.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p7.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p8.jpeg">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="images/p9.jpeg">
      </div>
    
      
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 class="fw-bold">Let's Build a Healthy Future Together</h2>
    <p class="lead">Become a customer or start your business journey with ARM Ayurveda.</p>
    <a href="{{route('products')}}" class="btn btn-gold me-2">Explore Products</a>
    <a href="{{route('register')}}" class="btn btn-light rounded-pill px-4">Join Now</a>
  </div>
</section>

<section class="about-contact">
  <div class="container">
    <div class="about-contact-shell">
      <div class="about-contact-intro">
        <img src="{{ asset('images/arm-ayurveda-logo.png') }}" class="about-contact-logo" alt="ARM Ayurveda">
        <div class="about-contact-kicker">Get in touch</div>
        <h2>Let’s grow healthier, together.</h2>
        <p>Have a question about our products, distributor programme or business opportunity? Our team is ready to help.</p>
        <a href="{{ route('contact') }}" class="about-contact-button">Visit contact page <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      <div class="about-contact-details">
        <h3>Connect with ARM Ayurveda</h3>
        <p>For enquiries, feedback and distributor support, reach us through the channel most convenient for you.</p>
        <div class="about-contact-list">
          <a href="tel:+919242068805" class="about-contact-item"><span class="about-contact-icon"><i class="fa-solid fa-phone-volume"></i></span><span class="about-contact-copy"><small>Call us</small><strong>+91 92420 68805</strong></span><i class="fa-solid fa-arrow-right about-contact-arrow"></i></a>
          <a href="mailto:armayurveda@gmail.com" class="about-contact-item"><span class="about-contact-icon"><i class="fa-regular fa-envelope"></i></span><span class="about-contact-copy"><small>Email us</small><strong>armayurveda@gmail.com</strong></span><i class="fa-solid fa-arrow-right about-contact-arrow"></i></a>
          <a href="{{ route('contact') }}#location" class="about-contact-item"><span class="about-contact-icon"><i class="fa-solid fa-location-dot"></i></span><span class="about-contact-copy"><small>Visit us</small><strong>Ashoknagar, North 24 Parganas, West Bengal</strong></span><i class="fa-solid fa-arrow-right about-contact-arrow"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

</div>
@endsection
