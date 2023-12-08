<?php

namespace nhattuanbl\Syslog\Http\Middleware;

use Closure;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use nhattuanbl\Syslog\Jobs\SyslogJob;
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
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (!empty($this->sysLogService->getLogs())) {
            SyslogJob::dispatch($this->sysLogService->getLogs())->onQueue(config('syslog.queue'))->onConnection(config('syslog.queue_connection'));
        }
    }
}
