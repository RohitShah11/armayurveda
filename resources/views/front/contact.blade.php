@extends('layouts.front')

@section('title', 'Contact Us | ARM Ayurveda Pvt. Ltd.')

@push('styles')
<style>
.contact-page{--contact-green:#075b2a;--contact-dark:#043d1d;--contact-gold:#dca11d;--contact-ink:#183025;--contact-muted:#66756d;overflow:hidden}.contact-hero{position:relative;isolation:isolate;padding:96px 0 92px;color:#fff;background:linear-gradient(90deg,rgba(3,59,27,.96) 0%,rgba(4,77,34,.89) 52%,rgba(4,77,34,.55) 100%),url('{{ asset('images/p7.jpeg') }}') center 48%/cover no-repeat}.contact-hero:after{content:"";position:absolute;z-index:-1;inset:auto 0 0;height:75px;background:linear-gradient(to top,#fff,transparent)}.hero-copy{max-width:690px}.eyebrow{display:inline-flex;align-items:center;gap:9px;margin-bottom:18px;padding:7px 14px;border:1px solid rgba(255,255,255,.32);border-radius:999px;background:rgba(255,255,255,.1);font-size:13px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}.contact-hero h1{margin:0 0 17px;font-size:clamp(42px,6vw,68px);line-height:1;font-weight:900;letter-spacing:-.035em}.contact-hero .lead{max-width:610px;margin:0;color:rgba(255,255,255,.88);font-size:18px;line-height:1.75}.hero-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:28px}.hero-btn{display:inline-flex;align-items:center;gap:9px;padding:12px 22px;border-radius:999px;text-decoration:none;font-weight:800;transition:.2s}.hero-btn.primary{background:var(--contact-gold);color:#fff;box-shadow:0 10px 25px rgba(220,161,29,.25)}.hero-btn.secondary{border:1px solid rgba(255,255,255,.45);background:rgba(255,255,255,.1);color:#fff}.hero-btn:hover{transform:translateY(-2px);color:#fff}.contact-main{padding:0 0 78px}.contact-cards{position:relative;z-index:2;margin-top:-34px}.contact-card-new{height:100%;padding:27px 25px;border:1px solid #e5ece7;border-radius:20px;background:#fff;box-shadow:0 14px 38px rgba(5,62,29,.09);transition:.25s}.contact-card-new:hover{transform:translateY(-5px);box-shadow:0 19px 44px rgba(5,62,29,.13)}.contact-card-new .icon{display:grid;place-items:center;width:54px;height:54px;margin-bottom:20px;border-radius:16px;background:#edf7ef;color:var(--contact-green);font-size:21px}.contact-card-new h3{margin:0 0 8px;color:var(--contact-dark);font-size:19px;font-weight:900}.contact-card-new p{min-height:45px;margin:0 0 15px;color:var(--contact-muted);line-height:1.6}.contact-card-new a{display:inline-flex;align-items:center;gap:7px;color:var(--contact-green);text-decoration:none;font-weight:800}.contact-card-new a:hover{color:var(--contact-gold)}.contact-grid{display:grid;grid-template-columns:minmax(0,.88fr) minmax(0,1.12fr);gap:30px;margin-top:58px}.support-panel{position:relative;overflow:hidden;padding:38px;border-radius:26px;background:linear-gradient(145deg,var(--contact-green),var(--contact-dark));color:#fff;box-shadow:0 20px 55px rgba(4,61,28,.17)}.support-panel:before{content:"";position:absolute;right:-90px;bottom:-100px;width:250px;height:250px;border:45px solid rgba(255,255,255,.045);border-radius:50%}.support-logo{width:105px;height:105px;margin-bottom:22px;padding:8px;border-radius:18px;background:#fff;object-fit:contain}.support-panel h2{margin-bottom:14px;font-size:30px;font-weight:900}.support-panel>p{color:rgba(255,255,255,.8);line-height:1.75}.support-list{display:grid;gap:13px;margin-top:26px}.support-item{display:flex;align-items:flex-start;gap:13px;padding:14px;border:1px solid rgba(255,255,255,.13);border-radius:14px;background:rgba(255,255,255,.07)}.support-item i{width:21px;margin-top:3px;color:#f4c453;text-align:center}.support-item strong{display:block;margin-bottom:2px}.support-item span{color:rgba(255,255,255,.73);font-size:13px}.help-panel{padding:38px;border:1px solid #e2ebe5;border-radius:26px;background:#f8fbf8}.section-kicker{margin-bottom:8px;color:var(--contact-gold);font-size:12px;font-weight:900;letter-spacing:.12em;text-transform:uppercase}.help-panel h2,.map-copy h2{margin:0;color:var(--contact-dark);font-size:32px;font-weight:900}.help-intro{margin:10px 0 25px;color:var(--contact-muted);line-height:1.7}.help-options{display:grid;grid-template-columns:1fr 1fr;gap:14px}.help-option{display:flex;gap:14px;padding:18px;border:1px solid #e2eae4;border-radius:17px;background:#fff;transition:.2s}.help-option:hover{border-color:#b8d5c0;box-shadow:0 9px 23px rgba(5,62,29,.07)}.help-option i{display:grid;place-items:center;flex:0 0 42px;height:42px;border-radius:13px;background:#eef7ef;color:var(--contact-green);font-size:17px}.help-option h3{margin:1px 0 5px;color:var(--contact-dark);font-size:15px;font-weight:900}.help-option p{margin:0;color:var(--contact-muted);font-size:12px;line-height:1.55}.response-note{display:flex;align-items:center;gap:12px;margin-top:20px;padding:15px 17px;border-left:4px solid var(--contact-gold);border-radius:10px;background:#fff8e9;color:#655021;font-size:13px}.map-section{padding:76px 0;background:#f4f8f4}.map-layout{display:grid;grid-template-columns:330px 1fr;gap:30px;align-items:stretch}.map-copy{display:flex;flex-direction:column;justify-content:center}.map-copy p{margin:15px 0 24px;color:var(--contact-muted);line-height:1.75}.map-link{display:inline-flex;align-items:center;gap:8px;align-self:flex-start;color:var(--contact-green);font-weight:900;text-decoration:none}.map-frame{min-height:390px;overflow:hidden;border:8px solid #fff;border-radius:25px;background:#e8eee9;box-shadow:0 17px 40px rgba(4,61,28,.12)}.map-frame iframe{width:100%;height:100%;min-height:374px;border:0}.contact-cta{padding:72px 0;text-align:center;background:#fff}.contact-cta-box{position:relative;overflow:hidden;padding:46px 25px;border-radius:28px;background:linear-gradient(120deg,#075b2a,#0c7137);color:#fff}.contact-cta-box:before,.contact-cta-box:after{content:"";position:absolute;width:180px;height:180px;border:35px solid rgba(255,255,255,.05);border-radius:50%}.contact-cta-box:before{left:-85px;top:-95px}.contact-cta-box:after{right:-80px;bottom:-105px}.contact-cta h2{position:relative;margin-bottom:10px;font-weight:900}.contact-cta p{position:relative;margin:0 auto 24px;color:rgba(255,255,255,.8)}.contact-cta .btn{position:relative}@media(max-width:991px){.contact-grid,.map-layout{grid-template-columns:1fr}.map-copy{text-align:center}.map-link{align-self:center}.contact-hero{text-align:center}.hero-copy{margin:auto}.hero-actions{justify-content:center}.contact-cards{margin-top:28px}.contact-main{padding-top:1px}}@media(max-width:575px){.contact-hero{padding:72px 0 64px}.contact-hero .lead{font-size:16px}.contact-main{padding-bottom:55px}.contact-card-new{padding:22px}.contact-grid{margin-top:38px}.support-panel,.help-panel{padding:26px 21px}.help-options{grid-template-columns:1fr}.map-section{padding:55px 0}.map-frame,.map-frame iframe{min-height:320px}.contact-cta{padding:52px 0}.contact-cta-box{padding:38px 18px}}
</style>
@endpush

@section('content')
<main class="contact-page">
  <section class="contact-hero">
    <div class="container">
      <div class="hero-copy">
        <div class="eyebrow"><i class="fa-solid fa-leaf"></i> We are here to help</div>
        <h1>Let’s start a conversation.</h1>
        <p class="lead">Whether you have a product question, need distributor support, or want to learn about the ARM Ayurveda business opportunity, our team is ready to guide you.</p>
        <div class="hero-actions">
          <a class="hero-btn primary" href="tel:+919242068805"><i class="fa-solid fa-phone"></i> Call our team</a>
          <a class="hero-btn secondary" href="mailto:armayurveda@gmail.com"><i class="fa-regular fa-envelope"></i> Send an email</a>
        </div>
      </div>
    </div>
  </section>

  <section class="contact-main">
    <div class="container">
      <div class="row g-4 contact-cards">
        <div class="col-lg-4"><article class="contact-card-new"><div class="icon"><i class="fa-solid fa-phone-volume"></i></div><h3>Call us</h3><p>Speak directly with our team for quick assistance.</p><a href="tel:+919242068805">+91 92420 68805 <i class="fa-solid fa-arrow-right"></i></a></article></div>
        <div class="col-lg-4"><article class="contact-card-new"><div class="icon"><i class="fa-regular fa-envelope"></i></div><h3>Email us</h3><p>Send your enquiry anytime and we will get back to you.</p><a href="mailto:armayurveda@gmail.com">armayurveda@gmail.com <i class="fa-solid fa-arrow-right"></i></a></article></div>
        <div class="col-lg-4"><article class="contact-card-new"><div class="icon"><i class="fa-solid fa-location-dot"></i></div><h3>Visit us</h3><p>Ashoknagar, North 24 Parganas, West Bengal, India.</p><a href="#location">View location <i class="fa-solid fa-arrow-down"></i></a></article></div>
      </div>

      <div class="contact-grid">
        <aside class="support-panel">
          <img class="support-logo" src="{{ asset('images/arm-ayurveda-logo.png') }}" alt="ARM Ayurveda">
          <h2>ARM Ayurveda Pvt. Ltd.</h2>
          <p>Healthy living and a stronger business community begin with the right support. Reach us through the channel that works best for you.</p>
          <div class="support-list">
            <div class="support-item"><i class="fa-solid fa-clock"></i><div><strong>Business hours</strong><span>Monday–Saturday, 10:00 AM–6:00 PM</span></div></div>
            <div class="support-item"><i class="fa-brands fa-whatsapp"></i><div><strong>WhatsApp support</strong><span>Message us on +91 92420 68805</span></div></div>
            <div class="support-item"><i class="fa-solid fa-location-dot"></i><div><strong>Registered location</strong><span>Ashoknagar, North 24 Parganas, West Bengal</span></div></div>
          </div>
        </aside>

        <section class="help-panel">
          <div class="section-kicker">Quick assistance</div>
          <h2>How can we help?</h2>
          <p class="help-intro">Choose your enquiry type when contacting us so our team can assist you faster.</p>
          <div class="help-options">
            <article class="help-option"><i class="fa-solid fa-box-open"></i><div><h3>Product enquiry</h3><p>Product details, pricing and availability.</p></div></article>
            <article class="help-option"><i class="fa-solid fa-user-plus"></i><div><h3>Distributor joining</h3><p>Registration and onboarding guidance.</p></div></article>
            <article class="help-option"><i class="fa-solid fa-chart-line"></i><div><h3>Business plan</h3><p>Understand the opportunity and benefits.</p></div></article>
            <article class="help-option"><i class="fa-solid fa-headset"></i><div><h3>Member support</h3><p>Account, order and distributor assistance.</p></div></article>
          </div>
          <div class="response-note"><i class="fa-solid fa-circle-check"></i><span>For the fastest response, call during business hours or send us an email with your member ID and enquiry details.</span></div>
        </section>
      </div>
    </div>
  </section>

  <section class="map-section" id="location">
    <div class="container">
      <div class="map-layout">
        <div class="map-copy"><div class="section-kicker">Our location</div><h2>Find us in West Bengal</h2><p>ARM Ayurveda Pvt. Ltd. is based in Ashoknagar, North 24 Parganas. Use the map to plan your visit.</p><a class="map-link" href="https://www.google.com/maps/search/?api=1&query=Ashoknagar%2C%20North%2024%20Parganas%2C%20West%20Bengal" target="_blank" rel="noopener">Open in Google Maps <i class="fa-solid fa-arrow-up-right-from-square"></i></a></div>
        <div class="map-frame"><iframe title="ARM Ayurveda location in Ashoknagar" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Ashoknagar%2C%20North%2024%20Parganas%2C%20West%20Bengal&output=embed"></iframe></div>
      </div>
    </div>
  </section>

  <section class="contact-cta">
    <div class="container"><div class="contact-cta-box"><h2>Ready to begin your ARM Ayurveda journey?</h2><p>Join as a customer or distributor and become part of our growing wellness community.</p><a href="{{ route('register') }}" class="btn btn-gold me-2">Join Now</a><a href="{{ route('products') }}" class="btn btn-light rounded-pill px-4">Explore Products</a></div></div>
  </section>
</main>
@endsection
