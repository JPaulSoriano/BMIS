<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id', 'passenger_id', 'start_terminal_id', 'end_terminal_id', 'pax', 'aboard', 'confirmed', 'travel_date'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function routes()
    {
        return $this->belongsTo(Route::class);
    }
}
