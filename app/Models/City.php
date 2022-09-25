<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class City extends Model
{
    protected $fillable = [
        'name',
        'external_id',
        'state_id'
    ];

    /**
     * If the model has timestamps fields or not
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the associated state
     * @return HasOne
     */
    public function state(): HasOne
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
}
