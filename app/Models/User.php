<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'uid',
        'phone',
        'account_id'
    ];

    /**
     * Returns the account that owns this user
     *
     * return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Returns the user's profile
     *
     * @return HasOne
     */
    public function userInfo(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * Returns the user's wardships
     *
     * @return HasMany
     */
    public function wardships(): HasMany
    {
        return $this->hasMany(Wardship::class);
    }
}
