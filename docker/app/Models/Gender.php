<?php

namespace App\Models;

class Gender extends Model
{
    protected $fillable = [
        'name',
        'initials'
    ];

    /**
     * If the model has timestamps fields or not
     * @var bool
     */
    public $timestamps = false;
}
