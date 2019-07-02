<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paystack Keys
    |--------------------------------------------------------------------------
    |
    | Public and private keys for your Paystack account which can be gotten form your
    | Paystack dashboard at https://paystack.com
    |
    */

    'public_key' => env('PAYSTACK_PK', 'pk_test_4283c4944dcf9a9620f04938c16ffe0a73229976'),
    'secret_key' => env('PAYSTACK_SK', 'sk_test_a78e919fde7316d6908a21f3f7459148192e1f08'),
];