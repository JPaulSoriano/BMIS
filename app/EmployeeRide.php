<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRide extends Model
{
    use HasFactory;

    protected $fillable = [
        'conductor_id', 'driver_id', 'travel_date', 'ride_code'
    ];

    protected $table = 'employee_ride';

    public function conductor()
    {
        return $this->belongsTo(User::class, 'conductor_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function departure()
    {
        return $this->hasOne(Departure::class, 'employee_ride_id');
    }

    public function arrival()
    {
        return $this->hasOne(Arrival::class, 'employee_ride_id');
    }
}
