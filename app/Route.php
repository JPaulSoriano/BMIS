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
        return $this->belongsToMany(Terminal::class, 'route_terminal')->withPivot(['order', 'minutes_from_departure'])->withTimestamps();
    }
}
