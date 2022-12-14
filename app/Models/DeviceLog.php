<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceLog extends Model
{
    /**
     * If the model has timestamps fields or not
     * @var bool
     */
    public $timestamps = false;

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
     * @return BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
