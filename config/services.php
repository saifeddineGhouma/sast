<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
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
        'client_id' => '240028203232352',
        'client_secret' => '0020eaf04c458acdccd69b77ecab3f78',
        'redirect' => 'https://swedish-academy.se/callbackfacebook',
    ],
    'twitter' => [
        'client_id' => 'CeTOLVzdTWhIr94umFZTZ6U9D',
        'client_secret' => 'RKfNQ24bmcjWRQYVfBFkB6bFjOH3rifB7ZyZgeOhdDtFurJmim',
        'redirect' => 'https://swedish-academy.se/callbacktwitter',
    ],
    'google' => [
        'client_id' => '885533949187-i1qujmlmskbt8dndr54ruaoofiohrhsm.apps.googleusercontent.com',
        'client_secret' => 'evpzR6VtsGoulcDG9qsK-X4B',
        'redirect' => 'https://swedish-academy.se/callbackgoogle',
    ],

];
