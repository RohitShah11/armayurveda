@extends('layouts.front')
@push('styles')
<style>
@media (max-width:575.98px){
  .about-page .container{padding-left:24px;padding-right:24px}
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
        <a href="products.html" class="btn btn-main mt-3">Explore Products</a>
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
    <div class="row g-5 align-items-center">
      <div class="col-lg-5">
        <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=900&q=80" class="director-img">
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
          <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=700&q=80">
          <div>
            <h5>Nutrition</h5>
            <p>Daily health and nutrition support.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=700&q=80">
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
        <img class="gallery-img" src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=700&q=80">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=700&q=80">
      </div>
      <div class="col-md-4">
        <img class="gallery-img" src="https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?auto=format&fit=crop&w=700&q=80">
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

<section class="section-padding contact-section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <h2 class="section-title">Contact Us</h2>
        <p>For product enquiry, joining or distributor support, contact ARM Ayurveda.</p>
        <p><i class="fa fa-phone text-danger"></i> +91 92420 68805</p>
        <p><i class="fa fa-envelope text-danger"></i> armayurveda@gmail.com</p>
        <p><i class="fa fa-location-dot text-danger"></i> Ashoknagar, North 24 Parganas, West Bengal</p>
      </div>

      <div class="col-lg-7">
        <form class="row g-3">
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Your Name">
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Mobile Number">
          </div>
          <div class="col-12">
            <input type="email" class="form-control" placeholder="Email Address">
          </div>
          <div class="col-12">
            <textarea class="form-control" placeholder="Your Message"></textarea>
          </div>
          <div class="col-12">
            <button class="btn btn-main">Submit Enquiry</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

</div>
@endsection
