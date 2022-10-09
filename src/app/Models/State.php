<?php

namespace App\Models;

class State extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * If the primary key is incremental
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key type
     * @var string
     */
    protected $keyType = 'string';

    /**
     * If the model has timestamps fields or not
     * @var bool
     */
    public $timestamps = false;
}
