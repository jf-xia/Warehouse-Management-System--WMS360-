<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'firebase' => [
        'api_key' => 'AIzaSyARHAojCzCMuN4g0xK46hcmV938SffY5BA', // Only used for JS integration
        'auth_domain' => 'warehouse-management-19424.firebaseapp.com', // Only used for JS integration
        'database_url' => 'https://warehouse-management-19424.firebaseio.com',
        'secret' => 'yq7MATK6mMvqxSE0qubTd1bAoc7t48KFQ9k4Mf30',
        'storage_bucket' => 'warehouse-management-19424.appspot.com', // Only used for JS integration
    ],
];
