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

        'jlseamless' => [
            'driver' => 'jlseamless',
            'api_url' => env('JLSEAMLESS_API_URL'),
            'agent_id' => env('JLSEAMLESS_AGENT_ID'),
            'agent_key' => env('JLSEAMLESS_AGENT_KEY'),
        ],

        'icgseamless' => [
            'driver' => 'icgseamless',
            'api_url' => env('ICGSEAMLESS_API_URL'),
            'token' => env('ICGSEAMLESS_TOKEN'),
        ],

    ],

];
