@extends('layouts.front')

@section('content')
<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-3">
        <img src="images/logo.jpeg" class="hero-logo" alt="ARM Ayurveda">
      </div>
      <div class="col-lg-6">
        <h1>PURE AYURVEDA</h1>
        <h3>FOR A HEALTHIER TOMORROW</h3>
        <p>Natural wellness products with a trusted business opportunity for a better future.</p>
        <a href="#" class="btn btn-green me-2"><i class="fa fa-bag-shopping"></i> EXPLORE PRODUCTS</a>
        <a href="#" class="btn btn-gold"><i class="fa fa-users"></i> JOIN BUSINESS</a>
      </div>
    </div>
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
          <img src="https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=600&q=80">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-spa"></i></div>
            <h5>AYURVEDIC CARE</h5>
            <p>Traditional wellness products</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=600&q=80">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-bottle-droplet"></i></div>
            <h5>PERSONAL CARE</h5>
            <p>Natural care for healthy life</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=600&q=80">
          <div class="category-body">
            <div class="circle-icon"><i class="fa fa-seedling"></i></div>
            <h5>HERBAL PRODUCTS</h5>
            <p>Pure herbal solutions</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=600&q=80">
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
      <a href="#" class="btn btn-outline-success rounded-pill">VIEW ALL PRODUCTS <i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=600&q=80">
          <div class="product-body">
            <h5>Herbal Face Care</h5>
            <p>Natural care for daily use</p>
            <div class="price">₹499</div>
            <a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="https://images.unsplash.com/photo-1611078489935-0cb964de46d6?auto=format&fit=crop&w=600&q=80">
          <div class="product-body">
            <h5>Ayurvedic Oil</h5>
            <p>Herbal oil for wellness</p>
            <div class="price">₹699</div>
            <a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=600&q=80">
          <div class="product-body">
            <h5>Herbal Supplement</h5>
            <p>Daily wellness support</p>
            <div class="price">₹999</div>
            <a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=600&q=80">
          <div class="product-body">
            <h5>Body Care Product</h5>
            <p>Natural personal care</p>
            <div class="price">₹599</div>
            <a href="#" class="btn btn-green btn-sm mt-2"><i class="fa fa-cart-shopping"></i> BUY NOW</a>
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
        <a href="#" class="btn btn-light rounded-pill px-4">JOIN NOW <i class="fa fa-user-plus"></i></a>
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

<section class="contact">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-3 text-center">
        <img src="images/logo.jpeg" class="contact-logo" alt="ARM Ayurveda">
      </div>

      <div class="col-lg-3">
        <h3 class="fw-bold text-success">GET IN TOUCH</h3>
        <p>For any enquiry, feedback or distributor support, please reach out to us.</p>
        <p><i class="fa fa-phone text-success"></i> +91 70851 70022</p>
        <p><i class="fa fa-envelope text-success"></i> armayurveda@gmail.com</p>
        <p><i class="fa fa-location-dot text-success"></i> Ashoknagar, North 24 Parganas, West Bengal</p>
      </div>

      <div class="col-lg-6">
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
            <button class="btn btn-green">SUBMIT ENQUIRY</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection