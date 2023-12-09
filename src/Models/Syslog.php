<?php

namespace nhattuanbl\Syslog\Models;

use Illuminate\Database\Eloquent\Model;
use nhattuanbl\Syslog\Services\SyslogService;

class Syslog
{
    public static function getModel(): string
    {
        if (config('syslog.connection') === 'mongodb') {
            return SyslogMongo::class;
        }

        return SyslogMysql::class;
    }

    public static function log(string $name, string $description = null, string $event = null, $subject = null, $causer = null, array $properties = [])
    {
        $logger = (Syslog::getModel())::newModelInstance([
            'name' => $name,
            'description' => $description,
            'event' => $event,
            'subject_id' => ($subject instanceof Model) ? $subject->id : null,
            'subject_type' => ($subject instanceof Model) ? get_class($subject) : null,
            'causer_id' => ($causer instanceof Model) ? $causer->id : null,
            'causer_type' => ($causer instanceof Model) ? get_class($causer) : null,
            'properties' => json_encode($properties),
        ]);

        $sysLogService = app(SyslogService::class);
        $sysLogService->addLog($logger);
    }
}
