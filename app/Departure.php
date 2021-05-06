<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departure extends Model
{
    use HasFactory;

    protected $fillable = [
        'or_no', 'terminal_id', 'time'
    ];

    public function employeeRide()
    {
        return $this->belongsTo(EmployeeRide::class, 'employee_ride_id');
    }

    public function totalPassenger()
    {
        return $this->employeeRide->ride->bookings->sum(function($bookings){
            if($bookings->aboard == 1) return $bookings->pax;
        });
    }

    public function getTimeAttribute()
    {
        return Carbon::parse($this->attributes['time']);
    }
}
