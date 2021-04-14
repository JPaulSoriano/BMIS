<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'route_name'
    ];

    public function terminals()
    {
        return $this->belongsToMany(Terminal::class, 'route_terminal')->withPivot(['order', 'minutes_from_departure'])->orderByPivot('order')->withTimestamps();
    }



    public function getTotalTimeAttribute()
    {
        $minutes = $this->terminals->map->pivot->flatten()->sum('minutes_from_departure');


        if (floor($minutes / 60) > 0) {
            return sprintf('%dh %02dmin', floor($minutes / 60), $minutes % 60);
        }

        return sprintf('%2dmin', floor($minutes % 60));

    }
}
