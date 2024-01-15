<?php

return [
    'connection' => env('SYSLOG_CONNECTION', 'mongodb'),

    'chunk' => (int) env('SYSLOG_CHUNK', 500),

    'queue' => env('SYSLOG_QUEUE', 'default'),

    'queue_connection' => env('SYSLOG_QUEUE_CONNECTION', 'sync'),

    'log-request' => env('SYSLOG_REQUEST', false),

    'log-memory' => env('SYSLOG_MEMORY', true),

    'log-session' => env('SYSLOG_SESSION', true),

    'log-headers' => env('SYSLOG_HEADERS', true),

    'except-request' => [

    ],
];
