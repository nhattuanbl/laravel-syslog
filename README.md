Package designed to enhance Laravel application's logging capabilities. It offers a robust solution for tracking and logging various model and application events.
 - Model Logging
 - Request Logging
 - Support MongoDB
 
## Installation
```
composer require nhattuanbl/syslog
```
Important: With version 5.4 or below, you must register your service providers manually in the providers section of the `config/app.php` configuration file in your laravel project.

```
'providers' => [
    // Other Service Providers

    nhattuanbl\SyslogServiceProvider::class,
],
```

Publish config file
```
php artisan vendor:publish --provider="nhattuanbl\syslog" --tag="config"
```
Publish migration file
```
php artisan vendor:publish --provider="nhattuanbl\syslog" --tag="migration"
```
```
php artisan migrate
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
### Custom log
```
use nhattuanbl\Syslog\Models\Syslog;

Syslog::log('auth', 'someone login', 'login', null, null, ['ip' => $request->ip()]);
```
