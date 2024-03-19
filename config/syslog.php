<?php

return [
    'connection' => env('SYSLOG_CONNECTION', 'mongodb'),

    'chunk' => (int) env('SYSLOG_CHUNK', 1000),

    'queue' => env('SYSLOG_QUEUE', 'default'),

    'log-request' => env('SYSLOG_REQUEST', false),

    'log-memory' => env('SYSLOG_MEMORY', true),

    'log-session' => env('SYSLOG_SESSION', true),

    'log-headers' => env('SYSLOG_HEADERS', true),

    'except-request' => [

    ],
];
