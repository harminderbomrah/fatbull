<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '613818930029278',
        'client_secret' => '8b723660c5286f1df69434b54d2a6835',
        'redirect' => env('APP_URL') . '/auth/facebook/callback',
    ],
    
    'google' => [
        'client_id' => '666838824608-1vvgvra5i915bsee42491qp1qrrg7pvi.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => env('APP_URL') . '/auth/google/callback',
    ],
];
