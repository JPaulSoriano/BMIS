<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureArrival extends Model
{
    use HasFactory;

    protected $table = 'departure_arrival';

    protected $fillable = [
        'or_no'
    ];

    public function employeeRide()
    {
        return $this->belongsTo(EmployeeRide::class, 'employee_ride_id');
    }
}
