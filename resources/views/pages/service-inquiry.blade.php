@extends('layouts.app')
@php
    $hotel = $type === 'hotel';
    $title = $hotel ? 'Hotel Booking' : 'Loan Requirement';
    $formRoute = $hotel ? 'hotel-booking' : 'loan-requirement';
@endphp
@section('title', $title)
@section('page-title', $title)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/service-inquiries.css') }}">
@endpush
@section('content')
<div class="inquiry-page">
  <section class="inquiry-hero">
    <div>
      <span class="inquiry-eyebrow">ARM AYURVEDA · MEMBER SERVICES</span>
      <h1>{{ $hotel ? 'Hotel Booking Inquiry' : 'Loan Requirement' }}</h1>
      <p>{{ $hotel ? 'A comfortable stay starts with a simple enquiry.' : 'Tell us your requirement. Let’s take the next step together.' }}</p>
      <div class="inquiry-benefits"><span><i class="fa fa-circle-check" aria-hidden="true"></i> {{ $hotel ? 'Family & guest stays' : 'Simple process' }}</span><span><i class="fa fa-circle-check" aria-hidden="true"></i> {{ $hotel ? 'Personal assistance' : 'Team follow-up' }}</span><span><i class="fa fa-circle-check" aria-hidden="true"></i> {{ $hotel ? 'Subject to availability' : 'Private enquiry' }}</span></div>
    </div>
    <div class="inquiry-hero-art" aria-hidden="true"><i class="fa {{ $hotel ? 'fa-bed' : 'fa-house-chimney' }}"></i><span>{{ $hotel ? 'Relax. Recharge.' : 'Support your goals.' }}</span></div>
  </section>
  <div class="inquiry-steps" aria-label="Request process"><span><b>1</b> Share your details</span><span><b>2</b> Our team reviews</span><span><b>3</b> We contact you</span></div>
  @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }} <a href="#request-history">View your requests</a></div>@endif
  @if($errors->any())<div class="alert alert-danger" role="alert"><strong>Please check your details.</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
  <div class="inquiry-grid">
    <section class="inquiry-card">
      <div class="inquiry-card-heading"><span class="inquiry-icon"><i class="fa {{ $hotel ? 'fa-file-lines' : 'fa-pen' }}" aria-hidden="true"></i></span><div><h2>{{ $hotel ? 'Booking Inquiry Form' : 'Loan Requirement Form' }}</h2><p>Our team will review your details and contact you.</p></div></div>
      <form action="{{ route($formRoute.'.store') }}" method="POST" class="inquiry-form">
        @csrf
        <p class="inquiry-required">Fields marked <span>*</span> are required.</p>
        <div class="inquiry-fields">
          <div><label for="full_name">Full Name <span>*</span></label><input id="full_name" name="full_name" class="form-control" value="{{ old('full_name', $user->name) }}" required maxlength="150" autocomplete="name"></div>
          <div><label for="member_id">Member ID</label><input id="member_id" class="form-control" value="{{ $user->member_id }}" readonly aria-describedby="member-id-help"><small id="member-id-help">Linked automatically to your account.</small></div>
          <div><label for="mobile">Mobile Number <span>*</span></label><input id="mobile" name="mobile" type="tel" class="form-control" value="{{ old('mobile', $user->mobile) }}" placeholder="10-digit mobile number" required pattern="[6-9][0-9]{9}" maxlength="10" autocomplete="tel-national"></div>
          <div><label for="email">Email ID</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="Your email address" maxlength="255" autocomplete="email"></div>
          @if($hotel)
            <div><label for="check_in">Check-in Date <span>*</span></label><input id="check_in" name="check_in" type="date" class="form-control" value="{{ old('check_in') }}" min="{{ now()->toDateString() }}" required></div>
            <div><label for="check_out">Check-out Date <span>*</span></label><input id="check_out" name="check_out" type="date" class="form-control" value="{{ old('check_out') }}" min="{{ now()->addDay()->toDateString() }}" required></div>
            <div><label for="guests">Number of Guests <span>*</span></label><input id="guests" name="guests" type="number" class="form-control" value="{{ old('guests', 1) }}" min="1" max="100" required></div>
            <div><label for="rooms">Number of Rooms <span>*</span></label><input id="rooms" name="rooms" type="number" class="form-control" value="{{ old('rooms', 1) }}" min="1" max="50" required></div>
            <div class="inquiry-wide"><label for="special_request">Special Request <small>(optional)</small></label><textarea id="special_request" name="special_request" class="form-control" maxlength="2000" rows="3" placeholder="Extra bed, early check-in or anything else we should know…">{{ old('special_request') }}</textarea></div>
          @else
            <div><label for="loan_type">Loan Type <span>*</span></label><select id="loan_type" name="loan_type" class="form-select" required><option value="">Select loan type</option>@foreach(\App\Models\ServiceInquiry::LOAN_TYPES as $option)<option @selected(old('loan_type') === $option)>{{ $option }}</option>@endforeach</select></div>
            <div><label for="amount">Loan Amount (₹) <span>*</span></label><input id="amount" name="amount" type="number" class="form-control" min="1" max="999999999.99" step="0.01" value="{{ old('amount') }}" placeholder="Enter required amount" required></div>
            <div><label for="purpose">Purpose of Loan <span>*</span></label><select id="purpose" name="purpose" class="form-select" required><option value="">Select purpose</option>@foreach(\App\Models\ServiceInquiry::PURPOSES as $option)<option @selected(old('purpose') === $option)>{{ $option }}</option>@endforeach</select></div>
            <div><label for="preferred_bank">Preferred Bank / NBFC <small>(optional)</small></label><input id="preferred_bank" name="preferred_bank" class="form-control" value="{{ old('preferred_bank') }}" maxlength="150" placeholder="Enter bank name"></div>
            <div><label for="city">City / Location <span>*</span></label><input id="city" name="city" class="form-control" value="{{ old('city', $user->city) }}" maxlength="150" autocomplete="address-level2" placeholder="Enter your city" required></div>
            <div><label for="remarks">Remarks <small>(optional)</small></label><textarea id="remarks" name="remarks" class="form-control" maxlength="2000" rows="3" placeholder="Additional information, if any…">{{ old('remarks') }}</textarea></div>
          @endif
        </div>
        <div class="inquiry-actions"><button type="submit" class="btn inquiry-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{ $hotel ? 'Submit Inquiry' : 'Submit Request' }}</button><a class="btn inquiry-reset" href="{{ route($formRoute) }}"><i class="fa fa-rotate-left" aria-hidden="true"></i> Reset</a></div>
      </form>
    </section>
    <aside class="inquiry-aside">
      @if($hotel)
      <section class="inquiry-rate"><i class="fa fa-bed" aria-hidden="true"></i><span>PLAN YOUR STAY</span><h2>₹{{ number_format(\App\Models\ServiceInquiry::ROOM_RATE) }}<small>per room / day</small></h2><p>Tell us your dates and preferences. Our team will confirm availability and booking details.</p></section>
      @endif
      <section class="inquiry-card inquiry-info"><h2><i class="fa fa-circle-info" aria-hidden="true"></i> Important Information</h2><ul>
        @if($hotel)
        <li>This is an enquiry. Your booking is confirmed only after our team contacts you.</li><li>Rooms are subject to availability.</li><li>Room rent is ₹{{ number_format(\App\Models\ServiceInquiry::ROOM_RATE) }} per room per day.</li><li>Please include any special requests in the form.</li>
        @else
        <li>This form records your loan requirement.</li><li>Our team will contact you for further discussion.</li><li>Please provide correct and valid information.</li><li>Loan approval is subject to bank / NBFC policies and eligibility criteria.</li>
        @endif
      </ul><div class="inquiry-help"><i class="fa fa-headset" aria-hidden="true"></i><div><strong>Need help?</strong><p>Speak with our support team.</p><a href="tel:+919242068805">+91 92420 68805</a></div></div></section>
      @unless($hotel)<section class="inquiry-card inquiry-promise"><i class="fa fa-seedling" aria-hidden="true"></i><h2>A step towards tomorrow</h2><p>Share your goals and let our team help you explore the next steps.</p></section>@endunless
    </aside>
  </div>
  <section id="request-history" class="inquiry-card inquiry-history">
    <div class="inquiry-card-heading"><span class="inquiry-icon"><i class="fa fa-clock-rotate-left" aria-hidden="true"></i></span><div><h2>Your {{ $hotel ? 'Booking Inquiries' : 'Loan Requests' }}</h2><p>Track progress and read updates from our team.</p></div></div>
    @forelse($inquiries as $inquiry)
    <details class="inquiry-record"><summary><strong>{{ $inquiry->reference() }}</strong><span>{{ $inquiry->created_at->format('d M Y') }}</span><span class="inquiry-status">{{ $inquiry->status }}</span><span class="inquiry-record-toggle">View details</span></summary><div class="inquiry-record-body">@include('partials.inquiry-details', ['inquiry' => $inquiry])<div class="inquiry-reply"><strong>Team update</strong><p>{{ $inquiry->admin_note ?: 'Your request has been received. Our team will contact you.' }}</p></div></div></details>
    @empty<p class="inquiry-empty">No requests yet. Submit the form above to get started.</p>@endforelse
    <div class="p-3">{{ $inquiries->links() }}</div>
  </section>
</div>
@endsection
@push('scripts')
@if($hotel)
<script>
const checkIn = document.getElementById('check_in');
const checkOut = document.getElementById('check_out');
function updateCheckoutMinimum() {
  if (!checkIn.value) return;
  const nextDay = new Date(checkIn.value + 'T00:00:00Z');
  nextDay.setUTCDate(nextDay.getUTCDate() + 1);
  checkOut.min = nextDay.toISOString().slice(0, 10);
}
checkIn.addEventListener('change', updateCheckoutMinimum);
updateCheckoutMinimum();
</script>
@endif
@endpush
