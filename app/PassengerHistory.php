<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id', 'passenger_id', 'start_terminal_id', 'end_terminal_id', 'pax', 'booking_code', 'point'
    ];
}
