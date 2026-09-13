@extends('layouts.admin')
@section('title', 'Repurchase Order Details')
@section('page-title', 'Repurchase Order Details')
@section('content')
@php($order = $productOrder)
<div class="d-flex justify-content-between align-items-center mb-3">
  <a href="{{ route('admin.product-orders.index') }}" class="btn btn-outline-dark"><i class="fa fa-arrow-left me-1"></i> Back to Orders</a>
  <span class="badge fs-6 {{ $order->status === 'Delivered' ? 'bg-success' : ($order->status === 'Cancelled' ? 'bg-danger' : 'bg-secondary') }}">{{ $order->status }}</span>
</div>
<div class="row g-4">
  <div class="col-lg-8">
    <div class="admin-card h-100"><h5 class="fw-bold mb-4">Order Information</h5><div class="row g-4">
      <div class="col-md-6"><small class="text-muted">Order Number</small><div class="fw-bold">{{ $order->order_number }}</div></div>
      <div class="col-md-6"><small class="text-muted">Ordered At</small><div>{{ $order->ordered_at?->format('d M Y, h:i A') }}</div></div>
      <div class="col-md-6"><small class="text-muted">Product</small><div class="fw-bold">{{ $order->product_name }}</div><small class="text-muted">Product ID: {{ $order->product_id ?: '—' }} · {{ $order->product?->category?->name ?: 'No category' }}</small></div>
      <div class="col-md-2"><small class="text-muted">Unit Price</small><div>₹{{ number_format($order->unit_price, 2) }}</div></div>
      <div class="col-md-2"><small class="text-muted">Quantity</small><div>{{ $order->quantity }}</div></div>
      <div class="col-md-2"><small class="text-muted">Total</small><div class="fw-bold text-success">₹{{ number_format($order->total_amount, 2) }}</div></div>
      <div class="col-md-6"><small class="text-muted">Payment Status</small><div><span class="badge {{ $order->payment_status === 'Paid' ? 'bg-success' : 'bg-info text-dark' }}">{{ $order->payment_status }}</span></div></div>
      <div class="col-md-6"><small class="text-muted">Current Order Status</small><div>{{ $order->status }}</div></div>
    </div></div>
  </div>
  <div class="col-lg-4">
    <div class="admin-card h-100"><h5 class="fw-bold mb-4">Member Details</h5>
      <small class="text-muted">Name</small><div class="fw-bold mb-3">{{ $order->user->name }}</div>
      <small class="text-muted">Member ID</small><div class="mb-3">{{ $order->user->member_id ?: '—' }}</div>
      <small class="text-muted">Mobile</small><div class="mb-3">{{ $order->user->profile?->mobile ?: $order->user->mobile ?: '—' }}</div>
      <small class="text-muted">Email</small><div>{{ $order->user->email ?: '—' }}</div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="admin-card"><h5 class="fw-bold mb-3"><i class="fa fa-location-dot me-2 text-success"></i>Delivery Address</h5><div style="white-space:pre-line">{{ $order->delivery_address ?: 'No delivery address recorded.' }}</div></div>
  </div>
  <div class="col-lg-4">
    <div class="admin-card"><h5 class="fw-bold mb-3">Update Status</h5>
      @if($order->availableStatuses())
      <form method="POST" action="{{ route('admin.product-orders.update', $order) }}">@csrf @method('PATCH')
        <label class="form-label">New Status</label><select class="form-select mb-3" name="status" required><option value="">Select status</option>@foreach($order->availableStatuses() as $status)<option value="{{ $status }}">{{ $status }}</option>@endforeach</select>
        <label class="form-label">Admin Note <span class="text-muted">(optional)</span></label><textarea class="form-control mb-3" name="admin_note" rows="3" maxlength="1000">{{ old('admin_note', $order->admin_note) }}</textarea>
        <button class="btn btn-main w-100">Update Order Status</button>
      </form>
      @else
      <div class="alert {{ $order->status === 'Delivered' ? 'alert-success' : 'alert-danger' }} mb-0">This order is {{ strtolower($order->status) }}. No further status changes are available.</div>
      @if($order->admin_note)<hr><small class="text-muted">Admin Note</small><div style="white-space:pre-line">{{ $order->admin_note }}</div>@endif
      @endif
    </div>
  </div>
</div>
@endsection
