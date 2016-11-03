<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1767350623526171',
        'client_secret' => '382c1f81dea4a50dd55b0dd4c80def23',
        'redirect' => 'http://localhost:8000/callback/facebook',
    ],

    'google' => [
        'client_id' => '679807988960-ta8bd0d43fse8hsg9kldkqbpgm5dhl5f.apps.googleusercontent.com',
        'client_secret' => 'dBB0cirgWvKkwvIPSRbMWu4S',
        'redirect' => 'http://localhost:8000/callback/google',
    ],

];
