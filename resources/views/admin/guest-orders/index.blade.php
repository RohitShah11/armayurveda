@extends('layouts.admin')
@section('title', 'Guest Product Orders')
@section('page-title', 'Guest Product Orders')
@section('content')
<div class="admin-card">
  <form method="GET" class="row g-2 mb-4">
    <div class="col-lg-5"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Order, customer, mobile, product or UTR..."></div>
    <div class="col-md-3 col-lg-2"><select class="form-select" name="status"><option value="">All statuses</option>@foreach(\App\Models\GuestProductOrder::STATUSES as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select></div>
    <div class="col-md-3"><select class="form-select" name="payment_method"><option value="">All payment methods</option>@foreach(\App\Models\GuestProductOrder::PAYMENT_METHODS as $method)<option value="{{ $method }}" @selected(request('payment_method') === $method)>{{ $method }}</option>@endforeach</select></div>
    <div class="col-auto"><button class="btn btn-outline-dark">Filter</button></div>
  </form>
  <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Order</th><th>Customer</th><th>Product</th><th>Total</th><th>Payment</th><th>Status</th><th>Ordered</th><th>Details</th></tr></thead><tbody>
    @forelse($orders as $order)
      <tr><td class="fw-bold">{{ $order->order_number }}</td><td>{{ $order->customer_name }}<br><small class="text-muted">{{ $order->mobile }}</small></td><td>{{ $order->product_name }}<br><small class="text-muted">₹{{ number_format($order->unit_price,2) }} × {{ $order->quantity }}</small></td><td class="fw-bold">₹{{ number_format($order->total_amount,2) }}</td><td>{{ $order->payment_method }}<br><span class="badge {{ $order->payment_status === 'Verified' || $order->payment_status === 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $order->payment_status }}</span></td><td><span class="badge {{ $order->status === 'Delivered' ? 'bg-success' : ($order->status === 'Cancelled' ? 'bg-danger' : 'bg-secondary') }}">{{ $order->status }}</span></td><td>{{ $order->ordered_at?->format('d M Y, h:i A') }}</td><td><a class="btn btn-sm btn-outline-dark text-nowrap" href="{{ route('admin.guest-orders.show',$order) }}"><i class="fa fa-eye me-1"></i> Review</a></td></tr>
    @empty<tr><td colspan="8" class="text-center text-muted py-5">No guest product orders found.</td></tr>@endforelse
  </tbody></table></div>
  {{ $orders->links() }}
</div>
@endsection
