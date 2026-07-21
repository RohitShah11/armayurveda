@extends('layouts.admin')
@section('title', 'Repurchase Orders')
@section('page-title', 'Repurchase Orders')
@section('content')
<div class="admin-card">
  <form method="GET" class="row g-2 mb-4"><div class="col-md-5"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Order, product, member name or ID..."></div><div class="col-md-3"><select name="status" class="form-select"><option value="">All statuses</option>@foreach(\App\Models\ProductOrder::STATUSES as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select></div><div class="col-auto"><button class="btn btn-outline-dark">Filter</button></div></form>
  <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Order</th><th>Member</th><th>Product</th><th>Total</th><th>Payment</th><th>Ordered</th><th style="min-width:260px">Update Status</th></tr></thead><tbody>
  @forelse($orders as $order)<tr><td class="fw-bold">{{ $order->order_number }}</td><td>{{ $order->user->name }}<br><small class="text-muted">{{ $order->user->member_id }}</small></td><td>{{ $order->product_name }}<br><small class="text-muted">₹{{ number_format($order->unit_price,2) }} × {{ $order->quantity }}</small></td><td>₹{{ number_format($order->total_amount,2) }}</td><td><span class="badge {{ $order->payment_status==='Paid'?'bg-success':'bg-info text-dark' }}">{{ $order->payment_status }}</span></td><td>{{ $order->ordered_at->format('d M Y, h:i A') }}</td><td><form method="POST" action="{{ route('admin.product-orders.update',$order) }}">@csrf @method('PATCH')<div class="d-flex gap-2"><select class="form-select form-select-sm" name="status" @disabled($order->status==='Cancelled')>@foreach(\App\Models\ProductOrder::STATUSES as $status)<option @selected($order->status===$status)>{{ $status }}</option>@endforeach</select><button class="btn btn-sm btn-main" @disabled($order->status==='Cancelled')>Save</button></div><input class="form-control form-control-sm mt-2" name="admin_note" value="{{ $order->admin_note }}" placeholder="Optional admin note" @disabled($order->status==='Cancelled')></form></td></tr>
  @empty<tr><td colspan="7" class="text-center text-muted py-5">No repurchase orders found.</td></tr>@endforelse
  </tbody></table></div>{{ $orders->links() }}
</div>
@endsection
