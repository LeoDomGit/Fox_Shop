<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Cho phép cả localhost và domain chính thức
    'allowed_origins' => [
        'http://localhost:3000',
        'https://foxshop.trungthanhzone.com',
    ],

    'allowed_methods' => ['*'], 
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, 
];
