<?php

namespace nhattuanbl\Syslog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use nhattuanbl\Syslog\Jobs\SyslogJob;
use nhattuanbl\Syslog\Models\Syslog;
use nhattuanbl\Syslog\Services\SyslogService;
use Symfony\Component\HttpFoundation\Response;

class SysLogMiddleware
{
    /** @var SyslogService SyslogService */
    public $sysLogService;
    public function __construct(SyslogService $sysLogService)
    {
        $this->sysLogService = $sysLogService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('syslog.log-request')) {
            $properties['request'] = $request->all();

            if (config('syslog.log-memory')) {
                $properties['memory'] = memory_get_usage();
            }

            if (config('syslog.log-headers')) {
                $properties['headers'] = $request->headers->all();
            }

            if (config('syslog.log-session')) {
                $properties['session'] = session()->all();
            }

            Syslog::log('request', $request->fullUrl(), $request->method(), $request->user(), null, $properties);
        }

        if (count($this->sysLogService->getLogs()) >= (int) config('syslog.chunk')) {
            SyslogJob::dispatch($this->sysLogService->getLogs())
                ->onQueue(config('syslog.queue'))
                ->onConnection(config('syslog.queue_connection'))
            ;
            $this->sysLogService->clearLogs();
        }

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (!empty($this->sysLogService->getLogs())) {
            SyslogJob::dispatch($this->sysLogService->getLogs())->onQueue(config('syslog.queue'))->onConnection(config('syslog.queue_connection'));
        }
    }
}
