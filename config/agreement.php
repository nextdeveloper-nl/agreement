<?php

return [

    'defaults' => [
        'service' => 'inspakt'
    ],

    'services' => [
        'inspakt' => [
            'api_key' => env('INSPAKT_API_KEY'),
            'api_url' => env('INSPAKT_API_URL'),
            'class' => \NextDeveloper\Agreement\Services\Clients\Inspakt::class,
        ],
    ],

];
