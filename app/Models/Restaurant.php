<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RestaurantOpenTime;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'note',
        'phone_number',
        'created_by',
        'updated_by',
        'is_deleted'
    ];

    public function openTimes()
    {
        return $this->hasMany(RestaurantOpenTime::class);
    }
    public function scopeFilterName($query, $name)
    {
        return $query->where('name', 'ILIKE', "%$name%");
    }

    public function scopeFilterDay($query, $day)
    {
        return $query->whereHas('openTimes', function ($q) use ($day) {
            $q->where('day_start', '<=', $day)
            ->where('day_end', '>=', $day);
        });
    }

    public function scopeFilterTime($query, $time)
    {
        return $query->whereHas('openTimes', function ($q) use ($time) {
            $q->where('time_start', '<=', $time)
            ->where('time_end', '>=', $time);
        });
    }
}