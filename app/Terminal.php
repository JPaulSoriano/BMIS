<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'terminal_name', 'terminal_address', 'user_id'
    ];

    public function routes()
    {
        return $this->belongsToMany(Route::class, 'route_terminal', 'route_id', 'terminal_id')->withPivot(['order', 'minutes_from_departure'])->withTimestamps();
    }

    public function minutesFromDepartureFormatted()
    {
        $minutes = $this->pivot->minutes_from_departure;

        if (floor($minutes / 60) > 0) {
            return sprintf('%dh %02dmin', floor($minutes / 60), $minutes % 60);
        }

        return sprintf('%2dmin', floor($minutes % 60));
    }


}
