<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'region',
        'country',
        'is_active',
        'sort_order',
    ];
}
