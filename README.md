Package designed to enhance Laravel application's logging capabilities. It offers a robust solution for tracking and logging various model and application events:
 - Model Event Tracking (Chunk insert)
 - MongoDB Support
 - Request Logging (Memory Usage, Session Data, Request Headers)

## Installation
Important: With version 5.4 or below, you must register your service providers manually in the providers section of the `config/app.php` configuration file in your laravel project.

```
'providers' => [
    // Other Service Providers

    nhattuanbl\SyslogServiceProvider::class,
],
```

Pushlish config file
```
php artisan vendor:publish --provider="nhattuanbl\syslog"
```
```
'connection' => env('SYSLOG_CONNECTION', env('DB_CONNECTION', 'mysql')), //support mongodb
'guard' => env('SYSLOG_GUARD', 'sanctum'), //for detect causer
'queue' => env('SYSLOG_QUEUE', 'default'),
'queue_connection' => env('SYSLOG_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync')),
'log-request' => env('SYSLOG_REQUEST', true),
'log-memory' => env('SYSLOG_MEMORY', true),
'log-session' => env('SYSLOG_SESSION', true),
'log-headers' => env('SYSLOG_HEADERS', true),
```

## Usage
### Tracking Model Events
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use nhattuanbl\Syslog\Traits\SyslogTrait;

class Product extends Model
{
    use SyslogTrait;
    ....
    
```
