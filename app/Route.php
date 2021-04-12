<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'route_name', 'from', 'to'
    ];

    public function terminals()
    {
        return $this->belongsToMany(Terminal::class, 'route_terminal')->withPivot(['order', 'minutes_from_departure'])->withTimestamps();
    }

    public function from_terminal()
    {
        return $this->belongsTo(Terminal::class, 'from');
    }

    public function to_terminal()
    {
        return $this->belongsTo(Terminal::class, 'to');
    }
}
