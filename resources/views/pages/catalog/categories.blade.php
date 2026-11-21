@extends('layouts.app')
@section('title', 'Repurchase')
@section('page-title', 'Repurchase Categories')

@push('styles')
<style>
.repurchase-page{min-height:calc(100vh - 72px);padding:22px;background:linear-gradient(145deg,#f8fbf4 0%,#eef7ec 48%,#f9fbf7 100%)}
.repurchase-shell{max-width:1540px;margin:0 auto}
.repurchase-hero{position:relative;min-height:270px;overflow:hidden;border:1px solid #dce9d6;border-radius:24px;background:#eaf5dc;box-shadow:0 13px 34px rgba(30,83,39,.12)}
.repurchase-hero-image{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center}
.repurchase-hero-overlay{position:absolute;inset:0;background:linear-gradient(90deg,rgba(244,251,235,.98) 0%,rgba(244,251,235,.94) 33%,rgba(244,251,235,.46) 58%,rgba(244,251,235,.04) 78%)}
.repurchase-hero-content{position:relative;z-index:1;width:min(620px,58%);padding:34px 40px 30px}
.repurchase-eyebrow{display:inline-flex;align-items:center;gap:8px;margin-bottom:8px;color:#247338;font-size:12px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase}
.repurchase-hero h1{margin:0;color:#153b21;font-family:Georgia,'Times New Roman',serif;font-size:clamp(36px,4.2vw,58px);font-weight:800;line-height:.98}.repurchase-hero h1 span{display:block;color:#2e7d32}
.repurchase-hero-copy{max-width:510px;margin:14px 0 21px;color:#506956;font-size:15px;line-height:1.55}
.repurchase-benefits{display:flex;flex-wrap:wrap;gap:9px}.repurchase-benefit{display:flex;align-items:center;gap:7px;padding:8px 11px;border:1px solid rgba(46,125,50,.17);border-radius:999px;background:rgba(255,255,255,.76);color:#245d31;font-size:12px;font-weight:700;backdrop-filter:blur(4px)}.repurchase-benefit i{color:#2e7d32}
.category-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin:28px 2px 15px}.category-heading h2{margin:0;color:#153b21;font-family:Georgia,'Times New Roman',serif;font-size:30px;font-weight:800}.category-heading p{margin:5px 0 0;color:#718077}.category-total{display:flex;align-items:center;gap:9px;color:#397047;font-size:13px;font-weight:700}.category-total span{display:grid;width:34px;height:34px;place-items:center;border-radius:50%;background:#dff0dc;color:#236b34}
.category-card{height:100%;overflow:hidden;border:1px solid #dfe8dc;border-radius:20px;background:#fff;box-shadow:0 8px 24px rgba(34,72,40,.08);transition:transform .24s ease,box-shadow .24s ease,border-color .24s ease}.category-card:hover{transform:translateY(-6px);border-color:#a7c9a7;box-shadow:0 17px 36px rgba(33,92,47,.15)}
.category-media-link{position:relative;display:block;height:186px;overflow:hidden;background:#dfead9}.category-image{width:100%;height:100%;object-fit:cover;transition:transform .45s ease}.category-card:hover .category-image{transform:scale(1.045)}
.category-media-link:after{content:"";position:absolute;inset:auto 0 0;height:50%;background:linear-gradient(180deg,transparent,rgba(9,56,23,.35))}
.category-icon{position:absolute;z-index:2;right:17px;bottom:14px;display:grid;width:48px;height:48px;place-items:center;border:4px solid rgba(255,255,255,.92);border-radius:50%;background:#f5fbef;color:#237338;font-size:19px;box-shadow:0 5px 15px rgba(0,0,0,.16)}
.category-body{display:flex;min-height:190px;flex-direction:column;padding:20px 20px 18px}.category-title{color:#173720;text-decoration:none}.category-title:hover{color:#2e7d32}.category-title h3{margin:0;font-family:Georgia,'Times New Roman',serif;font-size:20px;font-weight:800;line-height:1.15}
.category-meta{margin:8px 0 13px;color:#778078;font-size:13px}.subcategory-list{display:flex;flex-wrap:wrap;gap:6px;margin:0 0 15px}.subcategory-link{max-width:100%;overflow:hidden;padding:5px 9px;border:1px solid #d7e8d5;border-radius:999px;background:#f4f9f1;color:#397148;text-decoration:none;font-size:11px;text-overflow:ellipsis;white-space:nowrap}.subcategory-link:hover{border-color:#2e7d32;background:#e6f4e3;color:#1e632f}
.category-action{display:flex;align-items:center;justify-content:center;gap:9px;margin-top:auto;padding:9px 15px;border-radius:999px;background:linear-gradient(135deg,#438c1d,#176e31);color:#fff;text-decoration:none;font-size:13px;font-weight:800;box-shadow:0 7px 15px rgba(35,111,48,.18)}.category-action:hover,.category-action:focus{background:linear-gradient(135deg,#327914,#0f5b26);color:#fff}.category-action i{font-size:10px;transition:transform .2s}.category-action:hover i{transform:translateX(3px)}
.category-empty{padding:62px 24px;border:1px dashed #b9ceb8;border-radius:20px;background:rgba(255,255,255,.72);text-align:center}.category-empty i{color:#80a282}.category-empty h3{margin-top:14px;color:#244d2d}
@media(max-width:991px){.repurchase-hero-content{width:70%}.repurchase-hero-overlay{background:linear-gradient(90deg,rgba(244,251,235,.98) 0%,rgba(244,251,235,.9) 52%,rgba(244,251,235,.2) 100%)}}
@media(max-width:767px){.repurchase-page{padding:14px}.repurchase-hero{min-height:390px}.repurchase-hero-image{object-position:68% center}.repurchase-hero-overlay{background:linear-gradient(180deg,rgba(244,251,235,.97) 0%,rgba(244,251,235,.9) 52%,rgba(244,251,235,.22) 100%)}.repurchase-hero-content{width:100%;padding:27px 23px}.repurchase-hero h1{font-size:39px}.repurchase-hero-copy{font-size:14px}.repurchase-benefit{padding:7px 9px;font-size:11px}.category-heading{display:block}.category-total{margin-top:12px}.category-media-link{height:205px}}
@media(max-width:420px){.repurchase-benefits{display:grid;grid-template-columns:1fr 1fr}.repurchase-benefit{border-radius:12px}.category-card{border-radius:17px}}
</style>
@endpush

@section('content')
@php
  $fallbackArtwork = static function ($category): string {
      $identity = \Illuminate\Support\Str::lower($category->slug.' '.$category->name);
      return match (true) {
          str_contains($identity, 'child') || str_contains($identity, 'nutrition') => 'childrens-health-nutrition.jpg',
          str_contains($identity, 'digest') || str_contains($identity, 'gastric') => 'digestive-gastric-care.jpg',
          str_contains($identity, 'joint') || str_contains($identity, 'bone') || str_contains($identity, 'pain') => 'joint-bone-pain-care.jpg',
          str_contains($identity, 'kidney') || str_contains($identity, 'urinary') => 'kidney-urinary-care.jpg',
          str_contains($identity, 'liver') || str_contains($identity, 'detox') => 'liver-care-detox.jpg',
          str_contains($identity, 'nerve') || str_contains($identity, 'neuro') || str_contains($identity, 'brain') => 'nerve-neurological-wellness.jpg',
          str_contains($identity, 'respiratory') || str_contains($identity, 'allergy') || str_contains($identity, 'lung') => 'respiratory-allergy-care.jpg',
          default => 'general-wellness-immunity.jpg',
      };
  };

  $categoryIcon = static function ($category): string {
      $identity = \Illuminate\Support\Str::lower($category->slug.' '.$category->name);
      return match (true) {
          str_contains($identity, 'child') || str_contains($identity, 'nutrition') => 'fa-children',
          str_contains($identity, 'digest') || str_contains($identity, 'gastric') => 'fa-staff-snake',
          str_contains($identity, 'joint') || str_contains($identity, 'bone') || str_contains($identity, 'pain') => 'fa-person-walking',
          str_contains($identity, 'kidney') || str_contains($identity, 'urinary') => 'fa-droplet',
          str_contains($identity, 'liver') || str_contains($identity, 'detox') => 'fa-leaf',
          str_contains($identity, 'nerve') || str_contains($identity, 'neuro') || str_contains($identity, 'brain') => 'fa-brain',
          str_contains($identity, 'respiratory') || str_contains($identity, 'allergy') || str_contains($identity, 'lung') => 'fa-lungs',
          default => 'fa-shield-heart',
      };
  };
@endphp

<main class="repurchase-page">
  <div class="repurchase-shell">
    <section class="repurchase-hero" aria-labelledby="repurchase-heading">
      <img class="repurchase-hero-image" src="{{ asset('images/catalog/categories/repurchase-hero.jpg') }}" alt="" aria-hidden="true">
      <div class="repurchase-hero-overlay"></div>
      <div class="repurchase-hero-content">
        <span class="repurchase-eyebrow"><i class="fa fa-cart-arrow-down"></i> ARM Ayurveda wellness store</span>
        <h1 id="repurchase-heading">Repurchase <span>Product Categories</span></h1>
        <p class="repurchase-hero-copy">Choose a wellness category to explore authentic Ayurvedic products available for repurchase.</p>
        <div class="repurchase-benefits" aria-label="Product qualities">
          <span class="repurchase-benefit"><i class="fa fa-leaf"></i> Ayurvedic formulation</span>
          <span class="repurchase-benefit"><i class="fa fa-shield-halved"></i> Quality assured</span>
          <span class="repurchase-benefit"><i class="fa fa-flask"></i> Herbal &amp; natural</span>
          <span class="repurchase-benefit"><i class="fa fa-seedling"></i> Wellness focused</span>
        </div>
      </div>
    </section>

    <header class="category-heading">
      <div><h2>Choose a Category</h2><p>Select a category to view products available for repurchase.</p></div>
      <div class="category-total"><span>{{ $categories->count() }}</span> {{ \Illuminate\Support\Str::plural('category', $categories->count()) }} available</div>
    </header>

    <section class="row g-4" aria-label="Repurchase categories">
      @forelse($categories as $category)
        @php
          $hasUploadedImage = filled($category->image) && Storage::disk('public')->exists($category->image);
          $categoryImage = $hasUploadedImage ? '/storage/'.ltrim($category->image, '/') : asset('images/catalog/categories/'.$fallbackArtwork($category));
        @endphp
        <article class="col-sm-6 col-xl-3">
          <div class="category-card">
            <a href="{{ route('catalog.category', $category) }}" class="category-media-link" aria-label="View {{ $category->name }} products">
              <img class="category-image" src="{{ $categoryImage }}" alt="{{ $category->name }}" loading="lazy" decoding="async">
              <span class="category-icon" aria-hidden="true"><i class="fa {{ $categoryIcon($category) }}"></i></span>
            </a>
            <div class="category-body">
              <a href="{{ route('catalog.category', $category) }}" class="category-title"><h3>{{ $category->name }}</h3></a>
              <p class="category-meta">{{ $category->products_count }} direct {{ \Illuminate\Support\Str::plural('product', $category->products_count) }}</p>
              @if($category->children->isNotEmpty())
                <div class="subcategory-list" aria-label="{{ $category->name }} subcategories">
                  @foreach($category->children as $child)
                    <a class="subcategory-link" href="{{ route('catalog.category', $child) }}">{{ $child->name }} · {{ $child->products_count }}</a>
                  @endforeach
                </div>
              @endif
              <a class="category-action" href="{{ route('catalog.category', $category) }}">View Products <i class="fa fa-chevron-right"></i></a>
            </div>
          </div>
        </article>
      @empty
        <div class="col-12"><div class="category-empty"><i class="fa fa-layer-group fa-3x"></i><h3>No categories available</h3><p class="text-muted mb-0">Categories added by the admin will appear here.</p></div></div>
      @endforelse
    </section>
  </div>
</main>
@endsection
