@extends('layouts.app')

@section('title', 'Sportmortex')
@section('page-title', 'Sportmortex')

@push('styles')
<style>
:root {
      --primary: #ff4d00;
      --dark: #101820;
      --light: #f6f7f9;
    }

    body {
      font-family: Arial, sans-serif;
      background: var(--light);
      color: #222;
    }

    .top-bar {
      background: var(--primary);
      color: #fff;
      font-size: 14px;
      padding: 8px 0;
    }

    .navbar {
      background: #fff;
      box-shadow: 0 5px 18px rgba(0,0,0,.08);
    }

    .navbar-brand {
      font-weight: 900;
      font-size: 26px;
      color: var(--dark);
    }

    .navbar-brand span {
      color: var(--primary);
    }

    .nav-link {
      color: #222;
      font-weight: 600;
      margin: 0 6px;
    }

    .nav-link:hover {
      color: var(--primary);
    }

    .nav-icons a {
      color: #222;
      font-size: 20px;
      margin-left: 15px;
      text-decoration: none;
    }

    .hero {
      min-height: 560px;
      background:
        linear-gradient(rgba(0,0,0,.58), rgba(0,0,0,.58)),
        url("https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=1600&q=80");
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      color: #fff;
    }

    .hero h1 {
      font-size: 58px;
      font-weight: 900;
      line-height: 1.1;
    }

    .btn-orange {
      background: var(--primary);
      color: #fff;
      border-radius: 30px;
      padding: 11px 28px;
      font-weight: 700;
      border: none;
    }

    .btn-orange:hover {
      background: #df4300;
      color: #fff;
    }

    .section-title {
      text-align: center;
      margin-bottom: 40px;
    }

    .section-title h2 {
      font-weight: 900;
      text-transform: uppercase;
    }

    .service-box,
    .category-small,
    .product-card,
    .blog-card,
    .mini-section {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,.08);
    }

    .service-box {
      padding: 26px 16px;
      text-align: center;
      height: 100%;
    }

    .service-box i,
    .category-small i {
      font-size: 42px;
      color: var(--primary);
    }

    .category-banner {
      position: relative;
      border-radius: 24px;
      overflow: hidden;
      color: #fff;
    }

    .category-banner img {
      width: 100%;
      height: 310px;
      object-fit: cover;
      filter: brightness(50%);
      transition: .4s;
    }

    .category-banner:hover img {
      transform: scale(1.08);
    }

    .category-content {
      position: absolute;
      left: 30px;
      right: 30px;
      bottom: 30px;
      z-index: 2;
    }

    .category-small {
      text-align: center;
      padding: 26px 14px;
      transition: .3s;
      height: 100%;
    }

    .category-small:hover,
    .product-card:hover {
      transform: translateY(-7px);
    }

    .product-card {
      overflow: hidden;
      transition: .3s;
      position: relative;
      height: 100%;
    }

    .product-card img {
      width: 100%;
      height: 245px;
      object-fit: cover;
    }

    .discount-badge {
      position: absolute;
      top: 14px;
      left: 14px;
      background: var(--primary);
      color: #fff;
      padding: 6px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 800;
      z-index: 2;
    }

    .price {
      color: var(--primary);
      font-size: 20px;
      font-weight: 800;
    }

    .rating {
      color: #ffc107;
      font-size: 14px;
    }

    .trending-section {
      background:
        radial-gradient(circle at top left, rgba(255,77,0,.20), transparent 35%),
        linear-gradient(135deg, #101820, #172331);
      color: #fff;
    }

    .trending-label {
      background: rgba(255,255,255,.12);
      color: #ffb08a;
      padding: 8px 18px;
      border-radius: 30px;
      font-weight: 800;
      display: inline-block;
      margin-bottom: 12px;
    }

    .trending-header h2 {
      font-size: 42px;
      font-weight: 900;
      text-transform: uppercase;
    }

    .trending-header p {
      color: #cfd6df;
    }

    .trending-card {
      position: relative;
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.16);
      border-radius: 26px;
      overflow: hidden;
      backdrop-filter: blur(10px);
      transition: .35s;
      height: 100%;
    }

    .trending-card:hover {
      transform: translateY(-10px);
      background: rgba(255,255,255,.13);
    }

    .trending-img {
      padding: 18px;
    }

    .trending-img img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 20px;
    }

    .trending-body {
      padding: 20px;
    }

    .trending-body h5 {
      font-weight: 800;
    }

    .trending-body p {
      color: #cfd6df;
      font-size: 14px;
    }

    .hot-badge {
      position: absolute;
      top: 18px;
      right: 18px;
      background: var(--primary);
      color: #fff;
      padding: 7px 13px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 900;
      z-index: 3;
    }

    .trend-cart {
      width: 42px;
      height: 42px;
      background: var(--primary);
      color: #fff;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      font-size: 20px;
    }

    .trend-cart:hover {
      background: #fff;
      color: var(--primary);
    }

    .offer-box {
      background:
        linear-gradient(rgba(16,24,32,.88), rgba(16,24,32,.88)),
        url("https://images.unsplash.com/photo-1571019613914-85f342c1d8ef?auto=format&fit=crop&w=1200&q=80");
      background-size: cover;
      background-position: center;
      color: #fff;
      border-radius: 24px;
      padding: 60px 40px;
    }

    .mini-section {
      padding: 28px;
      height: 100%;
    }

    .mini-product {
      display: flex;
      gap: 15px;
      align-items: center;
      border-bottom: 1px solid #eee;
      padding: 16px 0;
    }

    .mini-product img {
      width: 90px;
      height: 90px;
      border-radius: 14px;
      object-fit: cover;
    }

    .blog-card {
      overflow: hidden;
      height: 100%;
    }

    .blog-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .blog-card a {
      color: var(--primary);
      font-weight: 700;
      text-decoration: none;
    }

    .newsletter {
      background: var(--dark);
      color: #fff;
      border-radius: 24px;
      padding: 45px 25px;
    }

    footer {
      background: var(--dark);
      color: #ccc;
      padding: 55px 0 18px;
    }

    footer h5 {
      color: #fff;
      font-weight: 800;
      margin-bottom: 18px;
    }

    footer a {
      color: #ccc;
      text-decoration: none;
      display: block;
      margin-bottom: 9px;
    }

    footer a:hover {
      color: var(--primary);
    }

    @media (max-width: 991px) {
      .hero {
        min-height: 480px;
        text-align: center;
      }

      .hero h1 {
        font-size: 42px;
      }

      .nav-icons {
        margin-top: 15px;
      }
    }

    @media (max-width: 576px) {
      .top-bar {
        text-align: center;
        font-size: 12px;
      }

      .navbar-brand {
        font-size: 22px;
      }

      .hero {
        min-height: 420px;
      }

      .hero h1 {
        font-size: 32px;
      }

      .hero p {
        font-size: 15px;
      }

      .category-banner img {
        height: 250px;
      }

      .category-content {
        left: 20px;
        right: 20px;
        bottom: 20px;
      }

      .product-card img,
      .trending-img img {
        height: 200px;
      }

      .trending-header h2 {
        font-size: 30px;
      }

      .offer-box {
        padding: 35px 22px;
        text-align: center;
      }

      .newsletter {
        padding: 32px 18px;
      }
    }
</style>
@endpush

@section('content')

@endsection
