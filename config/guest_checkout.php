<?php

return [
    'bank' => [
        'account_name' => env('GUEST_ORDER_ACCOUNT_NAME', 'ARM Ayurveda Pvt. Ltd.'),
        'bank_name' => env('GUEST_ORDER_BANK_NAME'),
        'account_number' => env('GUEST_ORDER_ACCOUNT_NUMBER'),
        'ifsc' => env('GUEST_ORDER_IFSC'),
        'branch' => env('GUEST_ORDER_BANK_BRANCH'),
        'upi' => env('GUEST_ORDER_UPI_ID'),
    ],
];
