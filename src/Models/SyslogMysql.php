<?php

namespace nhattuanbl\Syslog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string|null $name
 * @property string $description
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property int|null $causer_id
 * @property string $event
 * @property Collection|null $properties
 * @property Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Model $causer
 * @property-read Collection $changes
 * @property-read \Illuminate\Database\Eloquent\Model $subject
 * @mixin Model|\Illuminate\Database\Eloquent\Model|Builder
 */
class SyslogMysql extends Model
{
    protected $table = 'syslogs';
    protected $guarded = [];
    protected $dates = ['created_at'];
    CONST CREATED_AT = 'created_at';
    CONST UPDATED_AT = null;

    protected $fillable = [
        'name',
        'description',
        'event',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
    ];

    protected $casts = [
        'subject_id' => 'int',
        'causer_id' => 'int',
        'properties' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getConnectionName()
    {
        return config('syslog.connection', parent::getConnectionName());
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
