<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encadreur extends Model
{
    protected $fillable = [
        'city_id',
        'full_name',
        'phone_1',
        'email',
        'specialties',
        'notes',
        'is_active',
    ];
}
