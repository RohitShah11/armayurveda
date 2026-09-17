@extends('layouts.admin')
@section('title', 'Review Request')
@section('page-title', 'Review '.$inquiry->reference())
@push('styles')<link rel="stylesheet" href="{{ asset('css/service-inquiries.css') }}">@endpush
@section('content')
<a href="{{ route('admin.service-inquiries.index', ['type' => $inquiry->type]) }}" class="btn btn-outline-success mb-3">Back to {{ $inquiry->type === 'hotel' ? 'hotel' : 'loan' }} requests</a>
@if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
<div class="row g-4"><div class="col-lg-7"><section class="card border-0 shadow-sm p-4"><h2 class="h4">{{ $inquiry->type === 'hotel' ? 'Hotel Booking Inquiry' : 'Loan Requirement' }}</h2><p class="text-muted">{{ $inquiry->reference() }} · Member {{ $inquiry->user->member_id }} · {{ $inquiry->created_at->format('d M Y, h:i A') }}</p>@include('partials.inquiry-details')@if($inquiry->reviewed_at)<small class="text-muted">Last updated {{ $inquiry->reviewed_at->format('d M Y, h:i A') }}</small>@endif</section></div>
<div class="col-lg-5"><form method="POST" action="{{ route('admin.service-inquiries.update', $inquiry) }}" class="card border-0 shadow-sm p-4">@csrf @method('PATCH')<h2 class="h5">Update request</h2><label for="status" class="form-label mt-3">Status</label><select id="status" name="status" class="form-select" required>@foreach(\App\Models\ServiceInquiry::statuses($inquiry->type) as $status)<option @selected(old('status', $inquiry->status) === $status)>{{ $status }}</option>@endforeach</select><label for="admin_note" class="form-label mt-3">Reply to member</label><textarea id="admin_note" name="admin_note" rows="5" maxlength="2000" class="form-control">{{ old('admin_note', $inquiry->admin_note) }}</textarea><small class="text-muted mt-2">This note is visible to the member in their request history.</small><button class="btn btn-success mt-3">Save update</button></form></div></div>
@endsection
