<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class DeviceLog extends Model
{
    /**
     * Defines the timestamps column names
     *
     * @const string
     */
    const CREATED_AT = 'created_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'device_id',
        'latitude',
        'longitude',
        'altitude',
        'speed',
        'accuracy',
        'date',
        'time'
    ];

    /**
     * Returns the device that owns this log
     *
     * @return HasOne
     */
    public function device(): HasOne
    {
        return $this->hasOne(Device::class);
    }
}
