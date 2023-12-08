<?php

namespace nhattuanbl\Syslog\Models;

class Syslog
{
    public static function getModel(): string
    {
        if (config('syslog.connection') === 'mongodb') {
            return SyslogMongo::class;
        }

        return SyslogMysql::class;
    }
}
