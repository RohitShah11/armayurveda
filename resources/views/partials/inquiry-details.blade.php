@php
  $labels = ['loan_type' => 'Loan type', 'amount' => 'Loan amount (₹)', 'purpose' => 'Purpose', 'preferred_bank' => 'Preferred bank / NBFC', 'city' => 'City / location', 'remarks' => 'Remarks', 'check_in' => 'Check-in date', 'check_out' => 'Check-out date', 'guests' => 'Guests', 'rooms' => 'Rooms', 'special_request' => 'Special request', 'room_rate' => 'Room rate (₹ / day)'];
@endphp
<dl class="inquiry-detail-list">
  <div><dt>Full name</dt><dd>{{ $inquiry->full_name }}</dd></div><div><dt>Mobile number</dt><dd>{{ $inquiry->mobile }}</dd></div><div><dt>Email</dt><dd>{{ $inquiry->email ?: '—' }}</dd></div>
  @foreach($labels as $key => $label)
    @if(array_key_exists($key, $inquiry->details))<div><dt>{{ $label }}</dt><dd>{{ $inquiry->details[$key] ?? '—' }}</dd></div>@endif
  @endforeach
</dl>
