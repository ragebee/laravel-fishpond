<?php

declare (strict_types = 1);

return [

    /*
    |--------------------------------------------------------------------------
    | Fishpond dynamic register providr
    |--------------------------------------------------------------------------
     */

    'connections' => [

        'cq9slotseamless' => [
            'driver' => 'cq9slotseamless',
            'api_url' => env('CQ9SLOTSEAMLESS_API_URL'),
            'api_key' => env('CQ9SLOTSEAMLESS_API_KEY'),
        ],

    ],

];
