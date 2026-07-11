@extends('layouts.front')
@section('content')

<section class="hero">
  <div class="container">
    <h1>Our Products</h1>
    <p class="lead">Premium Ayurvedic, wellness and personal care products for every family.</p>
    <p>Home / Products</p>
  </div>
</section>

<section>
  <div class="container">
    <div class="search-box">
      <div class="row g-3">
        <div class="col-lg-8">
          <input type="text" class="form-control" placeholder="Search products...">
        </div>
        <div class="col-lg-4">
          <select class="form-select">
            <option>All Categories</option>
            <option>Health & Wellness</option>
            <option>Personal Care</option>
            <option>Skin Care</option>
            <option>Hair Care</option>
            <option>Daily Wellness</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container">
      
      
    <!--<div class="text-center">-->
    <!--  <h2 class="section-title">Product Showcase</h2>-->
    <!--  <p class="sub-title">Explore our basic product range. Replace names/images with your actual products anytime.</p>-->

    <!--  <div class="mb-4">-->
    <!--    <button class="category-btn active">All</button>-->
    <!--    <button class="category-btn">Health Care</button>-->
    <!--    <button class="category-btn">Personal Care</button>-->
    <!--    <button class="category-btn">Skin Care</button>-->
    <!--    <button class="category-btn">Hair Care</button>-->
    <!--    <button class="category-btn">Daily Wellness</button>-->
    <!--  </div>-->
    <!--</div>-->

    <div class="row g-4">

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Health Care</span>
            <h5>Ashwagandha Capsules</h5>
            <p>Herbal wellness support for strength and daily vitality.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Health Care</span>
            <h5>Giloy Tablets</h5>
            <p>Traditional Ayurvedic support for immunity and wellness.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Health Care</span>
            <h5>Tulsi Drops</h5>
            <p>Natural herbal drops for daily health and freshness.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1605191269771-8fa6947c19e1?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Health Care</span>
            <h5>Amla Juice</h5>
            <p>Rich herbal wellness drink for daily lifestyle support.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Health Care</span>
            <h5>Aloe Vera Juice</h5>
            <p>Daily wellness juice for natural health and digestion support.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1600428877878-1a0fd85beda0?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Health Care</span>
            <h5>Immunity Booster Syrup</h5>
            <p>Ayurvedic syrup for daily immunity and health support.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Personal Care</span>
            <h5>Herbal Face Wash</h5>
            <p>Gentle daily face wash made for clean and fresh skin.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Skin Care</span>
            <h5>Aloe Vera Gel</h5>
            <p>Cooling and soothing herbal gel for skin and hair care.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Hair Care</span>
            <h5>Herbal Shampoo</h5>
            <p>Natural hair cleanser for smooth and healthy-looking hair.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1611078489935-0cb964de46d6?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Hair Care</span>
            <h5>Herbal Hair Oil</h5>
            <p>Traditional herbal oil for scalp nourishment and care.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1607006483224-1fd3a5ba9434?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Personal Care</span>
            <h5>Herbal Soap</h5>
            <p>Refreshing herbal soap for daily bath and body care.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Personal Care</span>
            <h5>Herbal Toothpaste</h5>
            <p>Daily oral care with herbal freshness and protection.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Skin Care</span>
            <h5>Sandal Face Cream</h5>
            <p>Premium herbal cream for soft and glowing-looking skin.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Skin Care</span>
            <h5>Neem Face Pack</h5>
            <p>Herbal face pack for clean, fresh and healthy-looking skin.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1620917669788-3bbd53202d54?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Skin Care</span>
            <h5>Herbal Body Lotion</h5>
            <p>Soft and smooth body care for daily skin nourishment.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Daily Wellness</span>
            <h5>Herbal Green Tea</h5>
            <p>Refreshing herbal tea for a calm and healthy lifestyle.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Daily Wellness</span>
            <h5>Natural Honey</h5>
            <p>Pure honey for daily food, wellness and natural sweetness.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1600271886742-f049cd451bba?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Daily Wellness</span>
            <h5>Chyawanprash</h5>
            <p>Traditional Ayurvedic wellness support for the whole family.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1550572017-edd951aa8f72?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Women Care</span>
            <h5>Women's Wellness Capsules</h5>
            <p>Herbal wellness support specially created for women.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1628771065518-0d82f1938462?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Women Care</span>
            <h5>Iron & Calcium Supplement</h5>
            <p>Daily nutrition support for energy, strength and wellness.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Men Care</span>
            <h5>Men's Vitality Capsules</h5>
            <p>Herbal support for stamina, strength and daily confidence.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=700&q=80">
          <div class="product-body">
            <span class="badge-category">Men Care</span>
            <h5>Energy Tonic</h5>
            <p>Ayurvedic tonic for energy, active life and wellness support.</p>
            <a href="#" class="btn btn-main w-100">View Details</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container text-center">
    <h2 class="section-title">Why Choose ARM Products?</h2>
    <p class="sub-title">Our products are created to support natural wellness and customer trust.</p>

    <div class="row g-4">
      <div class="col-md-3 col-6">
        <div class="benefit-card">
          <div class="icon-box"><i class="fa fa-leaf"></i></div>
          <h5>Herbal Ingredients</h5>
          <p>Inspired by Ayurveda and natural wellness.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="benefit-card">
          <div class="icon-box"><i class="fa fa-shield-halved"></i></div>
          <h5>Quality Focus</h5>
          <p>Products selected with quality and care.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="benefit-card">
          <div class="icon-box"><i class="fa fa-hand-holding-heart"></i></div>
          <h5>Daily Wellness</h5>
          <p>Useful product range for regular lifestyle.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="benefit-card">
          <div class="icon-box"><i class="fa fa-users"></i></div>
          <h5>Trusted Brand</h5>
          <p>Customer and distributor focused company.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div class="catalogue-box">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <h2 class="fw-bold">Download Product Catalogue</h2>
          <p class="mb-0">Get complete details of ARM Ayurveda product range in PDF format.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="assets/product-catalogue.pdf" download class="btn btn-gold">
            <i class="fa fa-file-pdf"></i> Download Catalogue
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 class="fw-bold">Become a Distributor</h2>
    <p class="lead">Start your Ayurvedic product business with ARM Ayurveda and grow with dedicated support.</p>
    <a href="{{route('register')}}" class="btn btn-gold me-2">Join Now</a>
    <a href="{{route('contact')}}" class="btn btn-light rounded-pill px-4">Contact Us</a>
  </div>
</section>
@endsection