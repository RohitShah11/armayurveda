@extends('layouts.app')
@section('title', 'My Repurchase Orders')
@section('page-title', 'My Repurchase Orders')
@section('content')
<div class="container-fluid py-4"><div class="card shadow-sm"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Order</th><th>Product</th><th>Qty</th><th>Total</th><th>Payment</th><th>Status</th><th>Ordered</th></tr></thead><tbody>
@forelse($orders as $order)<tr><td class="fw-bold">{{ $order->order_number }}</td><td>@if($order->product)<a href="{{ route('catalog.show',$order->product) }}">{{ $order->product_name }}</a>@else{{ $order->product_name }}@endif</td><td>{{ $order->quantity }}</td><td>₹{{ number_format($order->total_amount,2) }}</td><td><span class="badge {{ $order->payment_status==='Paid'?'bg-success':'bg-info text-dark' }}">{{ $order->payment_status }}</span></td><td><span class="badge bg-secondary">{{ $order->status }}</span></td><td>{{ $order->ordered_at->format('d M Y, h:i A') }}</td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-5">You have not placed any repurchase orders.</td></tr>@endforelse
</tbody></table></div>{{ $orders->links() }}</div></div></div>
@endsection
