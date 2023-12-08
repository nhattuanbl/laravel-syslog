<?php

namespace nhattuanbl\Syslog\Services;

use nhattuanbl\Syslog\Models\SyslogMongo;
use nhattuanbl\Syslog\Models\SyslogMysql;

class SyslogService
{
    protected $sysLogChunk = [];

    /**
     * @param SyslogMongo|SyslogMysql $log
     * @return void
     */
    public function addLog($log)
    {
        $this->sysLogChunk[] = $log->toArray();
    }

    public function getLogs()
    {
        return $this->sysLogChunk;
    }

    public function clearLogs()
    {
        $this->sysLogChunk = [];
    }
}
