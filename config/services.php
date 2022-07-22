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

    'nexmo' => [
        'sms_from' => 'Laravel',
    ],

    'openWeatherMap' => [
        'key' => '5b111e3737b3102908663fd62419fd0b',
    ],

    'paypal' => [
        'mode' => 'sandbox',
        'client_id' => 'Ad-VFmB7RGvGkENlSjD6Ed19U3Jcit_mJ0Uz0RlLSrAjnY74nSZY3tsWk9Kj3EncxI5B_F--7UVonMAN',
        'secret' => 'EJdAeMuKNwFi0dyr2qGnlymnOjdTkCMi5w_WpSN-UHQK5g7-ZGokT2QSBe_3xp8iQ8qnIG9xfckfqDaz',
    ]

];
