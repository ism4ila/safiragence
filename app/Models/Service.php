<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'short_description',
        'price',
        'features',
        'is_featured',
        'is_active',
        'sort_order',
        'icon',
        'created_by',
    ];
}
