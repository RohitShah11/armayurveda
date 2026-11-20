@extends('layouts.app')
@section('title', 'Solar Panel Inquiry')
@section('page-title', 'Solar Panel Inquiry')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/service-inquiries.css') }}">
@endpush
@section('content')
<div class="inquiry-page">
  <section class="inquiry-hero">
    <div><span class="inquiry-eyebrow">ARM AYURVEDA · MEMBER SERVICES</span><h1>Solar Panel Inquiry</h1><p>Share your property and electricity requirements. Our team will contact you with the next steps.</p><div class="inquiry-benefits"><span><i class="fa fa-circle-check"></i> Site assessment</span><span><i class="fa fa-circle-check"></i> Capacity guidance</span><span><i class="fa fa-circle-check"></i> Team follow-up</span></div></div>
    <div class="inquiry-hero-art" aria-hidden="true"><i class="fa fa-solar-panel"></i><span>Power your future.</span></div>
  </section>
  <div class="inquiry-steps" aria-label="Inquiry process"><span><b>1</b> Share your details</span><span><b>2</b> Our team reviews</span><span><b>3</b> We contact you</span></div>
  @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }} <a href="#request-history">View your inquiries</a></div>@endif
  @if($errors->any())<div class="alert alert-danger" role="alert"><strong>Please check your details.</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
  <div class="inquiry-grid">
    <section class="inquiry-card">
      <div class="inquiry-card-heading"><span class="inquiry-icon"><i class="fa fa-solar-panel"></i></span><div><h2>Solar Panel Inquiry Form</h2><p>Fields marked * are required.</p></div></div>
      <form action="{{ route('solar-panel-inquiry.store') }}" method="POST" class="inquiry-form">@csrf
        <div class="inquiry-fields">
          <div><label for="full_name">Full Name <span>*</span></label><input id="full_name" name="full_name" class="form-control" value="{{ old('full_name', $user->name) }}" required maxlength="150" autocomplete="name"></div>
          <div><label for="member_id">Member ID</label><input id="member_id" class="form-control" value="{{ $user->member_id }}" readonly></div>
          <div><label for="mobile">Mobile Number <span>*</span></label><input id="mobile" name="mobile" type="tel" class="form-control" value="{{ old('mobile', $user->mobile) }}" required pattern="[6-9][0-9]{9}" maxlength="10" autocomplete="tel-national"></div>
          <div><label for="email">Email ID</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" maxlength="255" autocomplete="email"></div>
          <div><label for="property_type">Property Type <span>*</span></label><select id="property_type" name="property_type" class="form-select" required><option value="">Select property type</option>@foreach(\App\Models\ServiceInquiry::PROPERTY_TYPES as $option)<option @selected(old('property_type') === $option)>{{ $option }}</option>@endforeach</select></div>
          <div><label for="roof_type">Roof / Installation Type <span>*</span></label><select id="roof_type" name="roof_type" class="form-select" required><option value="">Select roof type</option>@foreach(\App\Models\ServiceInquiry::ROOF_TYPES as $option)<option @selected(old('roof_type') === $option)>{{ $option }}</option>@endforeach</select></div>
          <div><label for="monthly_bill">Average Monthly Bill (₹) <span>*</span></label><input id="monthly_bill" name="monthly_bill" type="number" class="form-control" value="{{ old('monthly_bill') }}" min="0" max="99999999.99" step="0.01" required></div>
          <div><label for="required_capacity">Required Capacity (kW) <small>(optional)</small></label><input id="required_capacity" name="required_capacity" type="number" class="form-control" value="{{ old('required_capacity') }}" min="0.1" max="10000" step="0.01" placeholder="Leave blank if unsure"></div>
          <div><label for="city">City / Location <span>*</span></label><input id="city" name="city" class="form-control" value="{{ old('city', $user->city) }}" required maxlength="150"></div>
          <div class="inquiry-wide"><label for="address">Installation Address <span>*</span></label><textarea id="address" name="address" class="form-control" required maxlength="500" rows="2">{{ old('address', $user->address) }}</textarea></div>
          <div class="inquiry-wide"><label for="remarks">Additional Details <small>(optional)</small></label><textarea id="remarks" name="remarks" class="form-control" maxlength="2000" rows="3">{{ old('remarks') }}</textarea></div>
        </div>
        <div class="inquiry-actions"><button type="submit" class="btn inquiry-submit"><i class="fa fa-paper-plane"></i> Submit Inquiry</button><a class="btn inquiry-reset" href="{{ route('solar-panel-inquiry') }}"><i class="fa fa-rotate-left"></i> Reset</a></div>
      </form>
    </section>
    <aside class="inquiry-aside"><section class="inquiry-card inquiry-info"><h2><i class="fa fa-circle-info"></i> Important Information</h2><ul><li>This form records your solar panel requirement.</li><li>Our team will contact you to discuss feasibility and next steps.</li><li>Final capacity and pricing depend on a technical assessment.</li><li>Please provide accurate property and electricity information.</li></ul><div class="inquiry-help"><i class="fa fa-headset"></i><div><strong>Need help?</strong><p>Speak with our support team.</p><a href="tel:+919242068805">+91 92420 68805</a></div></div></section><section class="inquiry-card inquiry-promise"><i class="fa fa-sun"></i><h2>Clean energy starts here</h2><p>We’ll help you understand the right solar setup for your needs.</p></section></aside>
  </div>
  <section id="request-history" class="inquiry-card inquiry-history">
    <div class="inquiry-card-heading"><span class="inquiry-icon"><i class="fa fa-clock-rotate-left"></i></span><div><h2>Your Solar Panel Inquiries</h2><p>Track progress and read updates from our team.</p></div></div>
    @forelse($inquiries as $inquiry)<details class="inquiry-record"><summary><strong>{{ $inquiry->reference() }}</strong><span>{{ $inquiry->created_at->format('d M Y') }}</span><span class="inquiry-status">{{ $inquiry->status }}</span><span class="inquiry-record-toggle">View details</span></summary><div class="inquiry-record-body">@include('partials.inquiry-details', ['inquiry' => $inquiry])<div class="inquiry-reply"><strong>Team update</strong><p>{{ $inquiry->admin_note ?: 'Your inquiry has been received. Our team will contact you.' }}</p></div></div></details>@empty<p class="inquiry-empty">No inquiries yet. Submit the form above to get started.</p>@endforelse
    <div class="p-3">{{ $inquiries->links() }}</div>
  </section>
</div>
@endsection
