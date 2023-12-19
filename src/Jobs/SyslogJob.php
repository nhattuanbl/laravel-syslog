<?php

namespace nhattuanbl\Syslog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use nhattuanbl\Syslog\Models\Syslog;
use nhattuanbl\Syslog\Models\SyslogMongo;
use nhattuanbl\Syslog\Models\SyslogMongo7;
use nhattuanbl\Syslog\Models\SyslogMysql;

class SyslogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Collection<SyslogMongo|SyslogMysql|SyslogMongo7> $sysLogChunk*/
    public $sysLogChunk;

    public function __construct($sysLogChunk)
    {
        $this->sysLogChunk = $sysLogChunk;
    }

    public function handle(): void
    {
        (Syslog::getModel())::insert($this->sysLogChunk->map(function($item) {
            $item['properties'] = empty($item['properties']) ? null : json_encode($item['properties']);
            $item['created_at'] = now();
            return $item;
        })->toArray());
    }
}
