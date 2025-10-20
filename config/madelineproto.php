<?php

return [
    'app_info' => [
        'api_id' => env('TELEGRAM_API_ID'),
        'api_hash' => env('TELEGRAM_API_HASH'),
    ],
    'logger' => [
        'logger_level' => 4,
    ],
    'serialization' => [
        'serialization_interval' => 30,
    ],
];