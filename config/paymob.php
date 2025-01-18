<?php

return [
    'base_url'    => env('PAYMOB_BASE_URL', 'https://accept.paymob.com'),
    'secret_key'  => env('PAYMOB_SECRET_KEY'),
    'public_key'  => env('PAYMOB_PUBLIC_KEY'),
    'api_key'     => env('PAYMOB_API_KEY'),
    'hmac_secret' => env('PAYMOB_HMAC_SECRET'),
];