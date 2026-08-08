@extends('layouts.app')

@section('title', 'Purchase Package')
@section('page-title', 'Purchase Package')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.package-card{background:#fff;border-radius:22px;overflow:hidden;box-shadow:0 8px 25px rgba(0,0,0,.08);height:100%;border:1px solid #eee}
.package-card img{width:100%;height:210px;object-fit:contain;background:#fff}
.package-
.package-body h5{color:var(--primary);font-weight:900}
.price{font-size:24px;font-weight:900;color:var(--primary)}
.mrp{text-decoration:line-through;color:#777}
.badge-zenith{background:#e8f5ff;color:#0d6efd}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:10px 24px}
.alert-note{background:var(--light);border-left:5px solid var(--primary);border-radius:14px;padding:18px}
.hidden{display:none}
@media(max-width:991px){}
</style>
@endpush

@section('content')

<div class="page-body">
    @error('package')
      <div class="alert alert-danger mb-4" role="alert">{{ $message }}</div>
    @enderror

<div class="row g-4 mb-4">
      <div class="col-lg-4">
        <div class="card-box">
          <h6>Main Wallet</h6>
          <h3 class="fw-bold text-success">₹{{ number_format(auth()->user()->main_wallet ?? 0, 2) }}</h3>
          <small>Package purchase amount will be deducted from wallet.</small>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card-box">
          <h6>Current Package</h6>
          <h3 class="fw-bold" id="currentPackage">{{ $currentPackage ?? 'Not Purchased' }}</h3>
          <small id="packageNote">{{ $currentPackage ? 'Your current package is active.' : 'No package has been purchased yet.' }}</small>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card-box">
          <h6>Available Package</h6>
          <h3 class="fw-bold {{ $hasPurchasedPackage ? 'text-success' : 'text-primary' }}" id="nextPackage">
            {{ $hasPurchasedPackage ? 'Purchased' : 'Zenith Package' }}
          </h3>
          <small>{{ $hasPurchasedPackage ? 'No additional package purchase is available.' : 'Choose an available Zenith package product.' }}</small>
        </div>
      </div>
    </div>

    <div class="alert-note mb-4">
      @if ($hasPurchasedPackage)
        <b>Package:</b> Your one-time package purchase is complete and the package is active.
      @else
        <b>Package:</b> Zenith Package is available directly. The purchase amount is deducted from your Main Wallet, and all Zenith benefits are processed after a successful purchase.
      @endif
    </div>

    @if ($hasPurchasedPackage)
      <div class="alert alert-success mb-4" role="alert">
        <h5 class="fw-bold mb-1"><i class="fa fa-check-circle me-2"></i>Package Already Purchased</h5>
        <p class="mb-0">Your package is active. Each user can purchase a package only once, so no additional package purchase is available.</p>
      </div>
    @else
    <section id="zenithSection">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div>
          <h4 class="fw-bold">Zenith Package</h4>
          <p class="mb-0 text-muted">Choose an available Zenith product to purchase the package.</p>
        </div>
        <span class="badge badge-zenith p-2">Available Now</span>
      </div>

      <div class="row g-4 mb-5">
        @foreach ($packages->where('category', 'Zenith') as $package)
          @php
            $packageImage = $package->image ?: 'images/zenith-package.jpeg';

            if (!str_starts_with($packageImage, 'http://') && !str_starts_with($packageImage, 'https://') && !str_starts_with($packageImage, '/')) {
                $packageImage = asset($packageImage);
            }
          @endphp
          <div class="col-lg-4 col-md-6">
            <div class="package-card">
              <img src="{{ $packageImage }}" alt="{{ $package->name }}">
              <div class="package-body">
                <span class="badge badge-zenith mb-2">{{ $package->category }} Package</span>
                <h5>{{ $package->name }}</h5>
                <p>{{ $package->description }}</p>
                <div class="price">₹{{ number_format($package->price, 2) }}</div>
                <form method="POST" action="{{ route('package.purchase.store') }}">
                  @csrf
                  <input type="hidden" name="package_id" value="{{ $package->id }}">
                  <button class="btn btn-main w-100 mt-3" type="submit">Purchase Now</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
        @if ($packages->isEmpty())
          <div class="col-12">
            <div class="alert alert-warning mb-0">No Zenith Package is currently available. Please contact support.</div>
          </div>
        @endif
      </div>
    </section>
    @endif

    <div class="card-box">
      <h5 class="fw-bold mb-3">Package Purchase History</h5>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>Date</th>
              <th>Package</th>
              <th>Product</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Invoice</th>
            </tr>
          </thead>
          <tbody id="historyTable">
            @if($purchaseHistory->isEmpty())
              <tr>
                <td colspan="6" class="text-center text-muted">No package purchased yet.</td>
              </tr>
            @else
              @foreach($purchaseHistory as $purchase)
                <tr>
                  <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('d M Y h:i A') : '-' }}</td>
                  <td>{{ $purchase->package_name }}</td>
                  <td>{{ $purchase->package->name ?? '-' }}</td>
                  <td>₹{{ number_format($purchase->package_price, 2) }}</td>
                  <td>
                    <span class="badge bg-success">{{ $purchase->status }}</span>
                  </td>
                  <td><a href="{{ route('package.purchase.invoice', $purchase) }}" class="btn btn-sm btn-success text-nowrap">View Invoice</a></td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>

</div>

@unless ($hasPurchasedPackage)
<!-- CONFIRM MODAL -->
<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Confirm Package Purchase</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><b>Package:</b> <span id="modalPackage"></span></p>
        <p><b>Product:</b> <span id="modalProduct"></span></p>
        <p><b>Amount:</b> ₹<span id="modalAmount"></span></p>
        <p><b>Wallet Balance:</b> ₹15,000</p>
        <div class="alert alert-warning mb-0">
          After purchase, this package section will not be shown again.
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-main" onclick="purchasePackage()">Purchase</button>
      </div>
    </div>
  </div>
</div>
@endunless
@endsection
