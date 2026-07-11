@extends('layouts.front')
@section('content')


<section class="hero">
  <div class="container">
    <h1>Gallery</h1>
    <p class="lead">Explore ARM Ayurveda product, wellness and business moments.</p>
    <p>Home / Gallery</p>
  </div>
</section>

<section class="section-padding">
  <div class="container text-center">
    <h2 class="section-title">Our Photo Gallery</h2>
    <p class="sub-title">A clean visual showcase for products, wellness, events and distributor activities.</p>

    <div class="mb-5">
      <button class="filter-btn active">All</button>
      <button class="filter-btn">Products</button>
      <button class="filter-btn">Wellness</button>
      <button class="filter-btn">Events</button>
      <button class="filter-btn">Business</button>
    </div>

    <div class="row g-4">
      <div class="col-lg-4">
        <div class="gallery-card large">
          <img src="https://images.unsplash.com/photo-1596178065887-1198b6148b2b?auto=format&fit=crop&w=800&q=80">
          <div class="gallery-overlay">
            <h5>Ayurvedic Wellness</h5>
            <p>Natural lifestyle and herbal care.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=800&q=80">
              <div class="gallery-overlay">
                <h5>Personal Care Products</h5>
                <p>Premium herbal product range.</p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=800&q=80">
              <div class="gallery-overlay">
                <h5>Herbal Supplements</h5>
                <p>Daily wellness support.</p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=800&q=80">
              <div class="gallery-overlay">
                <h5>Natural Ingredients</h5>
                <p>Inspired by nature and Ayurveda.</p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?auto=format&fit=crop&w=800&q=80">
              <div class="gallery-overlay">
                <h5>Quality & Care</h5>
                <p>Focused on trust and wellness.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="gallery-card">
          <img src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=800&q=80">
          <div class="gallery-overlay">
            <h5>Herbal Tea</h5>
            <p>Refreshing daily wellness.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="gallery-card">
          <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=800&q=80">
          <div class="gallery-overlay">
            <h5>Natural Honey</h5>
            <p>Pure and healthy lifestyle product.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="gallery-card">
          <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=800&q=80">
          <div class="gallery-overlay">
            <h5>Business Meeting</h5>
            <p>Distributor support and growth.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="gallery-card">
          <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=900&q=80">
          <div class="gallery-overlay">
            <h5>Team Growth</h5>
            <p>Building a strong product-based network.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="gallery-card">
          <img src="https://images.unsplash.com/photo-1600428877878-1a0fd85beda0?auto=format&fit=crop&w=900&q=80">
          <div class="gallery-overlay">
            <h5>Ayurveda Lifestyle</h5>
            <p>Natural wellness for every family.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container text-center">
    <h2 class="section-title">Video Gallery</h2>
    <p class="sub-title">Add YouTube video links later for product demos, business presentations and training sessions.</p>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="video-card">
          <div class="video-thumb">
            <img src="https://images.unsplash.com/photo-1505576399279-565b52d4ac71?auto=format&fit=crop&w=800&q=80">
            <div class="play-btn"><i class="fa fa-play"></i></div>
          </div>
          <div class="video-body">
            <h5>Product Introduction</h5>
            <p>ARM Ayurveda product overview video.</p>
            <a href="#" class="btn btn-main btn-sm">Watch Video</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="video-card">
          <div class="video-thumb">
            <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80">
            <div class="play-btn"><i class="fa fa-play"></i></div>
          </div>
          <div class="video-body">
            <h5>Business Presentation</h5>
            <p>Distributor opportunity and plan video.</p>
            <a href="#" class="btn btn-main btn-sm">Watch Video</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="video-card">
          <div class="video-thumb">
            <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=800&q=80">
            <div class="play-btn"><i class="fa fa-play"></i></div>
          </div>
          <div class="video-body">
            <h5>Training Session</h5>
            <p>Business and product training for partners.</p>
            <a href="#" class="btn btn-main btn-sm">Watch Video</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container text-center">
    <h2 class="section-title">Our Activities</h2>
    <p class="sub-title">ARM Ayurveda is focused on product awareness, customer support and distributor growth.</p>

    <div class="row g-4">
      <div class="col-md-3 col-6">
        <div class="event-card">
          <div class="event-icon mx-auto"><i class="fa fa-box-open"></i></div>
          <h5>Product Launch</h5>
          <p>Showcase new wellness products.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="event-card">
          <div class="event-icon mx-auto"><i class="fa fa-users"></i></div>
          <h5>Distributor Meet</h5>
          <p>Team growth and business discussion.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="event-card">
          <div class="event-icon mx-auto"><i class="fa fa-chalkboard-user"></i></div>
          <h5>Training</h5>
          <p>Product and business learning sessions.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="event-card">
          <div class="event-icon mx-auto"><i class="fa fa-handshake"></i></div>
          <h5>Customer Support</h5>
          <p>Helping customers choose right products.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 class="fw-bold">Want to Join ARM Ayurveda?</h2>
    <p class="lead">Start your Ayurvedic product business and grow with our support.</p>
    <a href="signup.html" class="btn btn-gold me-2">Join Now</a>
    <a href="contact.html" class="btn btn-light rounded-pill px-4">Contact Us</a>
  </div>
</section>

@endsection