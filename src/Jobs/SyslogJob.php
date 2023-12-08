<?php

namespace nhattuanbl\Syslog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use nhattuanbl\Syslog\Models\Syslog;

class SyslogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sysLogChunk;
    public function __construct($sysLogChunk)
    {
        $this->sysLogChunk = $sysLogChunk;
    }

    public function handle(): void
    {
        (Syslog::getModel())::insert($this->sysLogChunk);
    }
}
