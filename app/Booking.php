<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id', 'passenger_id', 'start_terminal_id', 'end_terminal_id', 'pax', 'aboard', 'status', 'travel_date', 'reason'
    ];

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function startTerminal()
    {
        return $this->belongsTo(Terminal::class, 'start_terminal_id');
    }

    public function endTerminal()
    {
        return $this->belongsTo(Terminal::class, 'end_terminal_id');
    }

    public function isRejected() : bool
    {
        return $this->reason != null;
    }
}
