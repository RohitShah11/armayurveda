@extends('layouts.admin')
@php($requestTitle = request('type') === 'loan' ? 'Loan Requests' : (request('type') === 'hotel' ? 'Hotel Requests' : 'Loan & Hotel Requests'))
@section('title', $requestTitle)
@section('page-title', $requestTitle)
@section('content')
<div class="card border-0 shadow-sm p-4">
  <h2 class="h5 mb-4">{{ $requestTitle }}</h2>
  <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Reference</th><th>Member</th><th>Type</th><th>Mobile</th><th>Status</th><th>Submitted</th><th>Action</th></tr></thead><tbody>@forelse($inquiries as $inquiry)<tr><td>{{ $inquiry->reference() }}</td><td>{{ $inquiry->full_name }}<br><small>{{ $inquiry->user->member_id }}</small></td><td>{{ $inquiry->type === 'hotel' ? 'Hotel Booking' : 'Loan Requirement' }}</td><td>{{ $inquiry->mobile }}</td><td>{{ $inquiry->status }}</td><td>{{ $inquiry->created_at->format('d M Y') }}</td><td><a class="btn btn-outline-success btn-sm" href="{{ route('admin.service-inquiries.show', $inquiry) }}">Review</a></td></tr>@empty<tr><td colspan="7" class="text-center py-4">No requests found.</td></tr>@endforelse</tbody></table></div>
  {{ $inquiries->links() }}
</div>
@endsection
