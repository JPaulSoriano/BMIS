<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'route_id', 'bus_id', 'ride_date', 'departure_time', 'auto_confirm'
    ];

    public function schedules()
    {
        return $this->hasOne(RideSchedule::class);
    }
}
