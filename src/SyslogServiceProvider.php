<?php

namespace nhattuanbl\Syslog;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use nhattuanbl\Syslog\Http\Middleware\SysLogMiddleware;
use nhattuanbl\Syslog\Services\SyslogService;

class SyslogServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/syslog.php' => config_path('syslog.php'),
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ]);

        //php artisan vendor:publish --tag=syslog --force
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/syslog'),
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/syslog'),
            __DIR__.'/../public' => public_path('vendor/syslog'),
            __DIR__.'/../resources/js' => public_path('vendor/syslog/js'),
            __DIR__.'/../resources/css' => public_path('vendor/syslog/css'),
        ], 'views');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'syslog');

        $this->mergeConfigFrom(__DIR__.'/../config/syslog.php', 'syslog');

        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(SysLogMiddleware::class);
    }

    public function register()
    {
        $this->app->singleton(SyslogService::class, function($app) {
            return new SysLogService();
        });
    }
}
