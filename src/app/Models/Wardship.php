<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wardship extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'gender_id',
        'city_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'email',
        'phone',
        'document',
        'uuid',
        'address',
        'zip_code'
    ];

    /**
     * Returns the user that owns this wardship
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the wardship's device
     *
     * @return HasOne
     */
    public function device(): HasOne
    {
        return $this->hasOne(Device::class);
    }

    /**
     * Returns the wardship's gender
     * 
     * @return BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Returns the wardship's city
     * 
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
