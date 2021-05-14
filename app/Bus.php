<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_no', 'bus_plate', 'bus_seat', 'company_id', 'bus_class_id', 'bus_name', 'conductor_id', 'driver_id'
    ];

    public function busClass()
    {
        return $this->belongsTo(BusClass::class);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function getRatePerKmAttribute()
    {
        return $this->busClass->rate;
    }

    public function conductor()
    {
        return $this->belongsTo(User::class, 'conductor_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function company()
    {
        return $this->belongsTo(BusCompanyProfile::class, 'company_id');
    }
}
