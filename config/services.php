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
        'domain' => 'edutechsolutionsbd.com',
        'secret' => 'key-6e3b2333dad7553fb6b10d7ab7ff16f5',
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => 'your-github-app-id',
        'client_secret' => 'your-github-app-secret',
        'redirect' => 'http://your-callback-url',
    ],

    'facebook' => [
        'client_id' => 'your-github-app-id',
        'client_secret' => 'your-github-app-secret',
        'redirect' => 'http://your-callback-url',
    ],

    'twitter' => [
        'client_id' => 'your-github-app-id',
        'client_secret' => 'your-github-app-secret',
        'redirect' => 'http://your-callback-url',
    ],

    'linkedin' => [
        'client_id' => 'your-github-app-id',
        'client_secret' => 'your-github-app-secret',
        'redirect' => 'http://your-callback-url',
    ],

    'google' => [
        #'client_id' => '590108288857-1dfhaa8lneulbvb5tvjboao9lerqavcv.apps.googleusercontent.com',
        #'client_secret' => 'sj6zr2IwPa7SyjCXgQ8tw4Hk',

        #'client_id' => '590108288857-5pupadvvc9h2bbg2nnrtt6mvnjdofvfs.apps.googleusercontent.com',
        #'client_secret' => '8Y_9AUY2M4zfr9InJFlN-fJf',
        'client_id' => '278913452022-kb1a5t1ot4v6s8419su6o7hqa46jgng1.apps.googleusercontent.com',
        'client_secret' => 'ZWvWPbIT86QUFRPYNUXhk8CQ',
        'redirect' => 'http://dev.affifact.com/auth/google/callback/app',
    ],



];
