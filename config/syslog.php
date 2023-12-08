<?php

return [
    //support mongodb
    'connection' => env('SYSLOG_CONNECTION', env('DB_CONNECTION', 'mysql')),

    //for detect causer
    'guard' => env('SYSLOG_GUARD', 'sanctum'),

    'queue' => env('SYSLOG_QUEUE', 'default'),

    'queue_connection' => env('SYSLOG_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync')),

    'log-request' => env('SYSLOG_REQUEST', true),

    'log-memory' => env('SYSLOG_MEMORY', true),

    'log-session' => env('SYSLOG_SESSION', true),

    'log-headers' => env('SYSLOG_HEADERS', true),
];
