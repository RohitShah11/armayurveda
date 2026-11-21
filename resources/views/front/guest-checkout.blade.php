@extends('layouts.front')
@section('title', 'Order '.$product->name)

@push('styles')
<style>
.guest-checkout{padding:52px 0 70px;background:linear-gradient(145deg,#f7faf3,#edf6e9)}
.checkout-title{color:#123d22;font-family:Georgia,'Times New Roman',serif;font-size:clamp(30px,4vw,44px);font-weight:800}.checkout-subtitle{color:#68756c}
.checkout-card{height:100%;padding:26px;border:1px solid #dfe8dc;border-radius:20px;background:#fff;box-shadow:0 12px 34px rgba(28,77,39,.09)}
.checkout-card h2{color:#194d29;font-size:20px;font-weight:800}.checkout-card .form-label{font-size:13px;font-weight:700;color:#35483a}.checkout-card .form-control,.checkout-card .form-select{min-height:48px;border-color:#d6e0d5;border-radius:11px}.checkout-card textarea.form-control{min-height:auto}
.order-product{display:flex;gap:16px;align-items:center;padding-bottom:20px;border-bottom:1px solid #e8eee6}.order-product img,.order-product-placeholder{width:92px;height:92px;flex:0 0 92px;border-radius:14px;object-fit:contain;background:#f1f5ee}.order-product-placeholder{display:grid;place-items:center;color:#7b957e;font-size:28px}.order-product h3{margin:0 0 5px;font-size:17px;font-weight:800}.order-product p{margin:0;color:#68756c;font-size:13px}
.summary-row{display:flex;justify-content:space-between;gap:15px;padding:10px 0;color:#56655a}.summary-row.total{margin-top:4px;padding-top:15px;border-top:1px solid #dfe8dc;color:#174d28;font-size:19px;font-weight:900}
.payment-options{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}.payment-option{position:relative}.payment-option input{position:absolute;opacity:0;pointer-events:none}.payment-option label{display:flex;min-height:95px;cursor:pointer;flex-direction:column;align-items:center;justify-content:center;gap:8px;padding:13px;border:1px solid #dce5da;border-radius:14px;background:#fafcf8;color:#526056;text-align:center;font-size:12px;font-weight:800;transition:.2s}.payment-option label i{font-size:22px;color:#4e8657}.payment-option input:checked+label{border-color:#2e7d32;background:#eaf6e7;color:#174d28;box-shadow:0 0 0 3px rgba(46,125,50,.1)}
.online-panel{margin-top:17px;padding:20px;border:1px solid #cce1c8;border-radius:15px;background:#f1f9ed}.online-panel[hidden]{display:none}.bank-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px;margin-bottom:16px}.bank-item{padding:10px 12px;border-radius:10px;background:#fff}.bank-item small{display:block;color:#788479;font-size:11px}.bank-item strong{display:block;overflow-wrap:anywhere;color:#254e2d;font-size:13px}.bank-warning{padding:12px;border-radius:10px;background:#fff4d8;color:#735800;font-size:13px}
.checkout-submit{width:100%;margin-top:22px;padding:13px 22px;border:0;border-radius:999px;background:linear-gradient(135deg,#348443,#075127);color:#fff;font-weight:800;box-shadow:0 9px 20px rgba(15,91,40,.22)}.checkout-submit:hover{color:#fff;background:linear-gradient(135deg,#287338,#043d1d)}
.secure-note{display:flex;gap:9px;align-items:flex-start;margin-top:15px;color:#718077;font-size:12px}.secure-note i{margin-top:2px;color:#2e7d32}
@media(max-width:767px){.guest-checkout{padding:32px 0 50px}.checkout-card{padding:20px}.payment-options{grid-template-columns:1fr}.payment-option label{min-height:65px;flex-direction:row}.bank-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
@php
  $hasProductImage = filled($product->image) && Storage::disk('public')->exists($product->image);
  $hasBankDetails = collect($bank)->except('account_name')->filter()->isNotEmpty();
@endphp
<section class="guest-checkout">
  <div class="container">
    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-success"><i class="fa fa-arrow-left me-1"></i> Back to product</a>
    <div class="mt-3 mb-4"><h1 class="checkout-title">Complete Your Order</h1><p class="checkout-subtitle mb-0">Enter your delivery details and choose how you would like to pay.</p></div>

    @if($errors->any())<div class="alert alert-danger"><strong>Please correct the highlighted details.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <form method="POST" action="{{ route('guest-orders.store', $product) }}" enctype="multipart/form-data" id="guestOrderForm">
      @csrf
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="checkout-card">
            <h2><i class="fa fa-location-dot me-2 text-success"></i>Contact &amp; Shipping Address</h2>
            <div class="row g-3 mt-1">
              <div class="col-md-6"><label class="form-label" for="customer_name">Full Name *</label><input class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" maxlength="150" autocomplete="name" required>@error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
              <div class="col-md-6"><label class="form-label" for="mobile">Mobile Number *</label><input class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" type="tel" value="{{ old('mobile') }}" pattern="[6-9][0-9]{9}" maxlength="10" autocomplete="tel-national" required>@error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
              <div class="col-12"><label class="form-label" for="email">Email Address <span class="text-muted">(optional)</span></label><input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
              <div class="col-12"><label class="form-label" for="shipping_address">Complete Shipping Address *</label><textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" rows="4" maxlength="1000" autocomplete="street-address" required>{{ old('shipping_address') }}</textarea>@error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
              <div class="col-md-5"><label class="form-label" for="city">City *</label><input class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" maxlength="150" autocomplete="address-level2" required>@error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
              <div class="col-md-5"><label class="form-label" for="state">State *</label><input class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', 'West Bengal') }}" maxlength="150" autocomplete="address-level1" required>@error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
              <div class="col-md-2"><label class="form-label" for="pincode">PIN Code *</label><input class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" value="{{ old('pincode') }}" pattern="[1-9][0-9]{5}" maxlength="6" inputmode="numeric" autocomplete="postal-code" required>@error('pincode')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>

            <h2 class="mt-5"><i class="fa fa-credit-card me-2 text-success"></i>Payment Method</h2>
            <div class="payment-options mt-3">
              @foreach([['Online','fa-building-columns','Bank / UPI transfer'],['Cash','fa-money-bill-wave','Cash payment'],['Cash on Delivery','fa-truck','Pay on delivery']] as [$method,$icon,$caption])
                <div class="payment-option"><input type="radio" id="payment_{{ $loop->index }}" name="payment_method" value="{{ $method }}" @checked(old('payment_method', 'Cash on Delivery') === $method) required><label for="payment_{{ $loop->index }}"><i class="fa {{ $icon }}"></i><span>{{ $method }}<br><small class="fw-normal">{{ $caption }}</small></span></label></div>
              @endforeach
            </div>

            <div class="online-panel" id="onlinePaymentPanel" hidden>
              <h3 class="h6 fw-bold text-success mb-3">Transfer payment using these details</h3>
              @if($hasBankDetails)
                <div class="bank-grid">
                  @foreach(['account_name'=>'Account Name','bank_name'=>'Bank Name','account_number'=>'Account Number','ifsc'=>'IFSC Code','branch'=>'Branch','upi'=>'UPI ID'] as $key=>$label)
                    @if(filled($bank[$key] ?? null))<div class="bank-item"><small>{{ $label }}</small><strong>{{ $bank[$key] }}</strong></div>@endif
                  @endforeach
                </div>
              @else
                <div class="bank-warning mb-3"><i class="fa fa-circle-info me-1"></i> Bank details are being configured. Please contact ARM Ayurveda before submitting an online payment.</div>
              @endif
              <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="utr_number">UTR / Transaction Reference *</label><input class="form-control @error('utr_number') is-invalid @enderror" id="utr_number" name="utr_number" value="{{ old('utr_number') }}" maxlength="100">@error('utr_number')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label" for="payment_proof">Payment Screenshot *</label><input class="form-control @error('payment_proof') is-invalid @enderror" id="payment_proof" name="payment_proof" type="file" accept="image/jpeg,image/png,image/webp">@error('payment_proof')<div class="invalid-feedback">{{ $message }}</div>@enderror<small class="text-muted">JPG, PNG or WebP; maximum 4 MB.</small></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <aside class="checkout-card position-sticky" style="top:95px">
            <h2>Order Summary</h2>
            <div class="order-product mt-3">
              @if($hasProductImage)<img src="{{ '/storage/'.ltrim($product->image, '/') }}" alt="{{ $product->name }}">@else<div class="order-product-placeholder"><i class="fa fa-leaf"></i></div>@endif
              <div><h3>{{ $product->name }}</h3><p>{{ $product->category->name }}</p><strong class="text-success">₹{{ number_format($product->retail_price, 2) }}</strong></div>
            </div>
            <div class="mt-3"><label class="form-label" for="quantity">Quantity</label><input class="form-control" id="quantity" name="quantity" type="number" min="1" max="99" value="{{ old('quantity', 1) }}" required></div>
            <div class="summary-row mt-3"><span>Unit price</span><strong>₹{{ number_format($product->retail_price, 2) }}</strong></div>
            <div class="summary-row"><span>Quantity</span><strong id="quantitySummary">{{ old('quantity', 1) }}</strong></div>
            <div class="summary-row total"><span>Total</span><span id="orderTotal">₹{{ number_format((float)$product->retail_price * (int)old('quantity', 1), 2) }}</span></div>
            <button class="checkout-submit" type="submit"><i class="fa fa-lock me-2"></i>Place Order</button>
            <p class="secure-note"><i class="fa fa-shield-halved"></i><span>Your payment screenshot is stored privately and can only be reviewed by authorized administrators.</span></p>
          </aside>
        </div>
      </div>
    </form>
  </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const panel = document.getElementById('onlinePaymentPanel');
  const utr = document.getElementById('utr_number');
  const proof = document.getElementById('payment_proof');
  const quantity = document.getElementById('quantity');
  const quantitySummary = document.getElementById('quantitySummary');
  const orderTotal = document.getElementById('orderTotal');
  const unitPrice = @json((float) $product->retail_price);

  function syncPayment() {
    const selected = document.querySelector('input[name="payment_method"]:checked');
    const online = selected && selected.value === 'Online';
    panel.hidden = !online;
    utr.required = online;
    proof.required = online;
  }
  function syncTotal() {
    const count = Math.max(1, Math.min(99, Number(quantity.value) || 1));
    quantitySummary.textContent = count;
    orderTotal.textContent = '₹' + (unitPrice * count).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
  }
  document.querySelectorAll('input[name="payment_method"]').forEach(input => input.addEventListener('change', syncPayment));
  quantity.addEventListener('input', syncTotal);
  syncPayment(); syncTotal();
});
</script>
@endpush
