<?php

namespace nhattuanbl\Syslog\Services;

use Illuminate\Support\Collection;
use nhattuanbl\Syslog\Models\SyslogMongo;
use nhattuanbl\Syslog\Models\SyslogMongo7;
use nhattuanbl\Syslog\Models\SyslogMysql;

class SyslogService
{
    /** @var Collection<SyslogMongo|SyslogMysql|SyslogMongo7> $sysLogChunk*/
    protected $sysLogChunk;

    public function __construct()
    {
        $this->sysLogChunk = new Collection();
    }

    /**
     * @param SyslogMongo|SyslogMysql|SyslogMongo7 $log
     * @return void
     */
    public function addLog($log)
    {
        $this->sysLogChunk->push($log);
    }

    /**
     * @return Collection<SyslogMongo|SyslogMysql|SyslogMongo7>
     */
    public function getLogs()
    {
        return $this->sysLogChunk;
    }

    public function clearLogs()
    {
        $this->sysLogChunk = new Collection();
    }
}
