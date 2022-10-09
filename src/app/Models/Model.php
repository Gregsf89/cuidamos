<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Notifications\Notifiable;

class Model extends EloquentModel
{
    use HasFactory, Notifiable;
}
