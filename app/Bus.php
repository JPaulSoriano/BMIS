<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_no', 'bus_plate', 'bus_seat', 'user_id', 'bus_class_id', 'bus_name'
    ];

    public function busClass()
    {
        return $this->belongsTo(BusClass::class);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
