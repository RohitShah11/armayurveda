@extends('layouts.front')
@section('content')

<section class="hero">
  <div class="container">
    <h1>Contact Us</h1>
    <p class="lead">We are here to help you with products, joining and business support.</p>
    <p>Home / Contact Us</p>
  </div>
</section>

<section class="section-padding">
  <div class="container text-center">
    <h2 class="section-title">Get In Touch</h2>
    <p class="sub-title">Contact ARM Ayurveda for product enquiry, distributor joining, business plan or support.</p>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="contact-card">
          <div class="contact-icon"><i class="fa fa-phone"></i></div>
          <h5>Call Us</h5>
          <p class="mb-1">+91 92420 68805</p>
          <p class="text-muted mb-0">Monday to Saturday</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="contact-card">
          <div class="contact-icon"><i class="fa fa-envelope"></i></div>
          <h5>Email Us</h5>
          <p class="mb-1">armayurveda@gmail.com</p>
          <p class="text-muted mb-0">Send your enquiry anytime</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="contact-card">
          <div class="contact-icon"><i class="fa fa-location-dot"></i></div>
          <h5>Visit Us</h5>
          <p class="mb-1">Ashoknagar, North 24 Parganas</p>
          <p class="text-muted mb-0">West Bengal, India</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-5">
        <div class="info-box">
          <img src="{{ asset('images/arm-ayurveda-logo.png') }}" alt="ARM Ayurveda">
          <h3 class="fw-bold mb-3">ARM Ayurveda Pvt. Ltd.</h3>
          <p>
            For product enquiry, distributor registration, business plan details or customer support, please contact us.
          </p>

          <ul class="info-list mt-4">
            <li>
              <i class="fa fa-phone"></i>
              <div>
                <b>Phone</b><br>
                +91 92420 68805
              </div>
            </li>

            <li>
              <i class="fa fa-envelope"></i>
              <div>
                <b>Email</b><br>
                armayurveda@gmail.com
              </div>
            </li>

            <li>
              <i class="fa fa-location-dot"></i>
              <div>
                <b>Address</b><br>
                Ashoknagar, North 24 Parganas, West Bengal, India
              </div>
            </li>

            <li>
              <i class="fa fa-clock"></i>
              <div>
                <b>Working Hours</b><br>
                Monday - Saturday, 10:00 AM - 6:00 PM
              </div>
            </li>
          </ul>

          <div class="mt-4">
            <a href="tel:+919242068805" class="btn btn-gold me-2"><i class="fa fa-phone"></i> Call Now</a>
            <a href="mailto:armayurveda@gmail.com" class="btn btn-light rounded-pill px-4"><i class="fa fa-envelope"></i> Email</a>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="form-box">
          <h3 class="section-title">Send Your Message</h3>
          <p class="text-muted mb-4">Fill the form below and our team will contact you soon.</p>

          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Your Name">
              </div>

              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Mobile Number">
              </div>

              <div class="col-md-6">
                <input type="email" class="form-control" placeholder="Email Address">
              </div>

              <div class="col-md-6">
                <select class="form-select">
                  <option>Select Enquiry Type</option>
                  <option>Product Enquiry</option>
                  <option>Distributor Joining</option>
                  <option>Business Plan</option>
                  <option>Customer Support</option>
                  <option>Other</option>
                </select>
              </div>

              <div class="col-12">
                <input type="text" class="form-control" placeholder="Subject">
              </div>

              <div class="col-12">
                <textarea class="form-control" placeholder="Write your message"></textarea>
              </div>

              <div class="col-12">
                <button class="btn btn-main w-100">Submit Enquiry</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div class="text-center">
      <h2 class="section-title">Find Us On Map</h2>
      <p class="sub-title">ARM Ayurveda Pvt. Ltd. is located in Ashoknagar, North 24 Parganas, West Bengal.</p>
    </div>

    <div class="map-box">
      <iframe 
        src="https://www.google.com/maps?q=Ashoknagar%2C%20North%2024%20Parganas%2C%20West%20Bengal&output=embed">
      </iframe>
    </div>
  </div>
</section>

<section class="section-padding soft-bg">
  <div class="container text-center">
    <h2 class="section-title">Quick Help</h2>
    <p class="sub-title">Choose the right support option for your need.</p>

    <div class="row g-4">
      <div class="col-md-3 col-6">
        <div class="quick-card">
          <i class="fa fa-box-open"></i>
          <h5>Product Enquiry</h5>
          <p>Ask about products and availability.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="quick-card">
          <i class="fa fa-user-plus"></i>
          <h5>Join Business</h5>
          <p>Get details about joining process.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="quick-card">
          <i class="fa fa-file-pdf"></i>
          <h5>Business Plan</h5>
          <p>Request complete business plan PDF.</p>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="quick-card">
          <i class="fa fa-headset"></i>
          <h5>Support</h5>
          <p>Customer and distributor support.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 class="fw-bold">Start Your Journey with ARM Ayurveda</h2>
    <p class="lead">Join us as a customer, distributor or business partner.</p>
    <a href="{{route('register')}}" class="btn btn-gold me-2">Join Now</a>
    <a href="{{route('products')}}" class="btn btn-light rounded-pill px-4">View Products</a>
  </div>
</section>

@endsection
