<?php

$base_dir = 'uploads';

return [
    'upload' => [
        'max_size'  => 51200,   // kb
        'max_width' => 1024,    // px
        'quality'   => 60,
        'paths' => [
            'default'  => $base_dir . DIRECTORY_SEPARATOR,
            'user'     => $base_dir . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR,
            'driver'   => $base_dir . DIRECTORY_SEPARATOR . 'drivers' . DIRECTORY_SEPARATOR,
        ],
    ],
    'crm_token' => env('CRM_TOKEN'),
    'crm_url' => env('CRM_URL'),
    'max_report_limit' => env('MAX_REPORT_LIMIT', 1000),
    'memory_limit' => env('MEMORY_LIMIT', 16384),
];
