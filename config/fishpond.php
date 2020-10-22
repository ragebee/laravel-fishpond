<?php

declare (strict_types = 1);

return [

    /*
    |--------------------------------------------------------------------------
    | Fishpond dynamic register providr
    |--------------------------------------------------------------------------
     */

    'connections' => [

        'cq9seamless' => [
            'driver' => 'cq9seamless',
            'api_url' => env('CQ9SEAMLESS_API_URL'),
            'api_key' => env('CQ9SEAMLESS_API_KEY'),
        ],

    ],

];
