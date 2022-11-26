<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'imei',
        'uuid',
        'carrier_name',
        'carrier_number'
    ];

    /**
     * Returns the wardship that owns this device
     *
     * @return BelongsTo
     */
    public function wardship(): BelongsTo
    {
        return $this->belongsTo(Wardship::class);
    }

    /**
     * Returns the device's logs
     *
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(DeviceLog::class);
    }
}
