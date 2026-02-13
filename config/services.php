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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Django API Service
    |--------------------------------------------------------------------------
    |
    | Configuration for the Django backend API.
    | DJANGO_API_URL must be set in your .env file.
    | Example: DJANGO_API_URL=https://your-ngrok-url.ngrok-free.app
    |
    */

    'django_api' => [
        'url'      => env('DJANGO_API_URL'),           // e.g. https://xxx.ngrok-free.app
        // 'domain' => env('DJANGO_DOMAIN', '127.0.0.1'), // used for cookies if needed
    //     'username' => env('DJANGO_API_USERNAME'),
    //     'password' => env('DJANGO_API_PASSWORD'),
    //     'use_mock' => env('DJANGO_API_USE_MOCK', false),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];