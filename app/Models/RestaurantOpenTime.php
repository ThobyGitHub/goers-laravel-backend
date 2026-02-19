<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantOpenTime extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'restaurant_id',
        'day_start',
        'day_end',
        'time_start',
        'time_end',
    ];
}