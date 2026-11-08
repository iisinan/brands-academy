<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Annual Membership Dues Schedule
    |--------------------------------------------------------------------------
    |
    | Tiered pricing based on membership category:
    | Student (₦10,000), Professional (₦25,000), Corporate (₦75,000), Fellow (₦150,000)
    |
    */
    'fees' => [
        'student' => [
            'amount' => 10000,
            'label' => 'Student Member',
            'badge' => 'Tertiary & Early Career',
            'description' => 'Annual dues for currently enrolled tertiary students and early career brand apprentices.',
        ],
        'professional' => [
            'amount' => 25000,
            'label' => 'Professional Member',
            'badge' => 'Practicing Professional',
            'description' => 'Annual dues for practicing visual designers, brand architects, strategists, and marketing practitioners.',
        ],
        'corporate' => [
            'amount' => 75000,
            'label' => 'Corporate Member',
            'badge' => 'Enterprise & Studio',
            'description' => 'Annual institutional registration for agencies, design studios, corporate organisations, and SME teams.',
        ],
        'fellow' => [
            'amount' => 150000,
            'label' => 'Fellow / Academic Member',
            'badge' => 'Distinguished Faculty',
            'description' => 'Distinguished faculty fellows, university professors, and senior executive advisory members.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Foundation Bank Account Details (for Manual Bank Transfers)
    |--------------------------------------------------------------------------
    */
    'bank_details' => [
        'bank_name' => env('FOUNDATION_BANK_NAME', 'Zenith Bank Plc'),
        'account_name' => env('FOUNDATION_ACCOUNT_NAME', 'Brands Academy Nigeria Foundation'),
        'account_number' => env('FOUNDATION_ACCOUNT_NUMBER', '1012345678'),
        'swift_code' => env('FOUNDATION_SWIFT_CODE', 'ZEIBNGLA'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Paystack Payment Gateway Integration
    |--------------------------------------------------------------------------
    */
    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY', ''),
        'secret_key' => env('PAYSTACK_SECRET_KEY', ''),
        'payment_url' => 'https://api.paystack.co',
    ],
];
