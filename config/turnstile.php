<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Turnstile Site Key
    |--------------------------------------------------------------------------
    |
    | The Turnstile site key from your Cloudflare dashboard.
    | This is the public key that will be used in the frontend.
    |
    */
    'turnstile_site_key' => env('TURNSTILE_SITE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Turnstile Secret Key
    |--------------------------------------------------------------------------
    |
    | The Turnstile secret key from your Cloudflare dashboard.
    | This is the private key used for server-side validation.
    |
    */
    'turnstile_secret_key' => env('TURNSTILE_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Turnstile Validation URL
    |--------------------------------------------------------------------------
    |
    | The URL used to validate the Turnstile token.
    | You typically don't need to change this.
    |
    */
    'turnstile_validation_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
];
