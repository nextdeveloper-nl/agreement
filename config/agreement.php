<?php

return [

    'defaults' => [
        'service' => 'inspakt',
        'template_id' => env('AGREEMENT_TEMPLATE_ID'),
        'document_name' => env('AGREEMENT_DOCUMENT_NAME', 'User Agreement'),
        'channel' => env('AGREEMENT_CHANNEL', 'SMS'),
    ],

    'services' => [
        'inspakt' => [
            'api_key' => env('INSPAKT_API_KEY'),
            'api_url' => env('INSPAKT_API_URL'),
            'class' => \NextDeveloper\Agreement\Services\Clients\Inspakt::class,
        ],
    ],

];
