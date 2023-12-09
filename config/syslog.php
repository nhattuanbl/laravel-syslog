<?php

return [
    //support mongodb
    'connection' => env('SYSLOG_CONNECTION', env('DB_CONNECTION')),

    //for detect causer
    'guard' => env('SYSLOG_GUARD', 'sanctum'),

    'chunk' => (int) env('SYSLOG_CHUNK', 0),

    'queue' => env('SYSLOG_QUEUE', 'default'),

    'queue_connection' => env('SYSLOG_QUEUE_CONNECTION', env('QUEUE_CONNECTION')),

    'log-request' => env('SYSLOG_REQUEST', true),

    'log-memory' => env('SYSLOG_MEMORY', true),

    'log-session' => env('SYSLOG_SESSION', true),

    'log-headers' => env('SYSLOG_HEADERS', true),
];
