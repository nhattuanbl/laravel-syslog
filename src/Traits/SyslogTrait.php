<?php

namespace nhattuanbl\Syslog\Traits;

use Illuminate\Database\Eloquent\Model;
use nhattuanbl\Syslog\Jobs\SyslogJob;
use nhattuanbl\Syslog\Models\Syslog;
use nhattuanbl\Syslog\Services\SyslogService;

/**
 * @property callable $SyslogTap
 * @property array $SyslogEvents
 * @mixin Model
 */
trait SyslogTrait
{
    public $SyslogTap = null;
    public static $SyslogEvents = ['created', 'updated', 'deleted', 'restored'];

    protected static function bootSysLogTrait()
    {
        foreach (static::$SyslogEvents as $event) {
            if (!method_exists(static::class, $event)) {
                continue;
            }

            static::$event(function ($model) use ($event) {
                $model->captureActivity($event);
            });
        }
    }

    protected function captureActivity(string $event): void
    {
        $properties = null;
        if ($event == 'updated') {
            foreach($this->getDirty() as $key => $value) {
                if (in_array($key, [
                    $this->getCreatedAtColumn(),
                    $this->getUpdatedAtColumn(),
                    (method_exists($this, 'getDeletedAtColumn') ? $this->getDeletedAtColumn() : null)
                ])) {
                    continue;
                }

                $properties['attributes'][] = $key;
                $properties['old'][] = [$key => $this->getOriginal($key)];
                $properties['new'][] = [$key => $this->{$key}];
            }
        }

        $logger = (Syslog::getModel())::newModelInstance([
            'name' => null,
            'description' => null,
            'event' => $event,
            'subject_id' => $this->id,
            'subject_type' => static::class,
            'causer_id' => null,
            'causer_type' => null,
            'properties' => $properties,
            'created_at' => now(),
        ]);

        $auth = auth(config('syslog.guard'));
        if (!isset($logger->causer_id) && $auth->check()) {
            $logger->causer_id = $auth->user()->id;
            $logger->causer_type = get_class($auth->user());
        }

        if (is_callable($this->SyslogTap)) {
            ($this->SyslogTap)($logger);
        }

        $sysLogService = app(SyslogService::class);
        $sysLogService->addLog($logger);

        if ($sysLogService->getLogs()->count() >= (int) config('syslog.chunk')) {
            SyslogJob::dispatch($sysLogService->getLogs())
                ->onQueue(config('syslog.queue'))
                ->onConnection(config('syslog.queue_connection'))
            ;
            $sysLogService->clearLogs();
        }
    }
}
