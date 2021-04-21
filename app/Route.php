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

    public function getFirstTerminalAttribute()
    {
        return $this->terminals->first()->terminal_name;
    }

    public function getLastTerminalAttribute()
    {
        $lastTerminal = $this->terminals->map->pivot->sortByDesc('order')->first()->terminal_id;

        return $this->terminals->where('id', $lastTerminal)->first()->terminal_name;
    }

    public function getTotalTimeAttribute()
    {
        return $this->terminals->last()->minutesFromDepartureFormatted();
    }
}
