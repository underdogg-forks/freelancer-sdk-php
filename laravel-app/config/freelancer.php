<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Freelancer API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your Freelancer.com API credentials here.
    | You can obtain an OAuth token from https://developers.freelancer.com
    |
    */

    'oauth_token' => env('FREELANCER_OAUTH_TOKEN', ''),

    'api_url' => env('FREELANCER_API_URL', 'https://www.freelancer.com'),

    /*
    |--------------------------------------------------------------------------
    | Use Sandbox Environment
    |--------------------------------------------------------------------------
    |
    | Set to true to use the Freelancer.com sandbox environment for testing.
    |
    */

    'use_sandbox' => env('FREELANCER_USE_SANDBOX', false),

    'sandbox_url' => 'https://www.freelancer-sandbox.com',
];
