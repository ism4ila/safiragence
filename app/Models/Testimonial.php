<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'client_city',
        'content',
        'service_type',
        'rating',
        'is_featured',
        'created_by',
    ];
}
