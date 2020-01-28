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
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK_URL'),
        // The URL that listens to Google webhook notifications (Part 3).
        'webhook_uri' => env('GOOGLE_WEBHOOK_URI'),
        // Enables automatic token refresh.
        'approval_prompt' => 'force',
        'access_type' => 'offline',

        // Enables incremental scopes (useful if in the future we need access to another type of data).
        'include_granted_scopes' => true,
    ],
    // 'github' => [
    //     'client_id' => env('GITHUB_CLIENT_ID'),
    //     'client_secret' => env('GITHUB_CLIENT_SECRET'),
    //     'redirect' => 'http://your-callback-url',
    // ],
    // 'github' => [
    //     'client_id' => env('GITHUB_CLIENT_ID'),
    //     'client_secret' => env('GITHUB_CLIENT_SECRET'),
    //     'redirect' => 'http://your-callback-url',
    // ],
];
