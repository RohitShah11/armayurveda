<?php

namespace App\Http\Controllers;

use App\Models\ServiceInquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceInquiryController extends Controller
{
    public function index(Request $request, string $type)
    {
        return view($type === 'solar' ? 'pages.solar-panel-inquiry' : 'pages.service-inquiry', [
            'type' => $type,
            'user' => $request->user(),
            'inquiries' => ServiceInquiry::where('user_id', $request->user()->id)->where('type', $type)->latest()->paginate(10),
        ]);
    }

    public function store(Request $request, string $type)
    {
        $rules = [
            'full_name' => ['required', 'string', 'max:150'],
            'mobile' => ['required', 'string', 'regex:/^[6-9][0-9]{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
        $rules += match ($type) {
            'hotel' => [
            'check_in' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:100'],
            'rooms' => ['required', 'integer', 'min:1', 'max:50'],
            'special_request' => ['nullable', 'string', 'max:2000'],
            ],
            'solar' => [
                'property_type' => ['required', Rule::in(ServiceInquiry::PROPERTY_TYPES)],
                'roof_type' => ['required', Rule::in(ServiceInquiry::ROOF_TYPES)],
                'city' => ['required', 'string', 'max:150'],
                'address' => ['required', 'string', 'max:500'],
                'monthly_bill' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
                'required_capacity' => ['nullable', 'numeric', 'min:0.1', 'max:10000', 'decimal:0,2'],
                'remarks' => ['nullable', 'string', 'max:2000'],
            ],
            default => [
            'loan_type' => ['required', Rule::in(ServiceInquiry::LOAN_TYPES)],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999.99', 'decimal:0,2'],
            'purpose' => ['required', Rule::in(ServiceInquiry::PURPOSES)],
            'preferred_bank' => ['nullable', 'string', 'max:150'],
            'city' => ['required', 'string', 'max:150'],
            'remarks' => ['nullable', 'string', 'max:2000'],
            ],
        };
        $data = $request->validate($rules, ['mobile.regex' => 'Enter a valid 10-digit Indian mobile number.']);
        $contact = array_intersect_key($data, array_flip(['full_name', 'mobile', 'email']));
        $details = array_diff_key($data, $contact);
        if ($type === 'hotel') {
            $details['room_rate'] = ServiceInquiry::ROOM_RATE;
        }
        $inquiry = ServiceInquiry::create($contact + [
            'user_id' => $request->user()->id,
            'type' => $type,
            'details' => $details,
            'status' => 'Pending',
        ]);

        $route = match ($type) {
            'hotel' => 'hotel-booking',
            'solar' => 'solar-panel-inquiry',
            default => 'loan-requirement',
        };

        return redirect()->route($route)
            ->with('success', 'Your request '.$inquiry->reference().' has been submitted. Our team will contact you.');
    }
}
