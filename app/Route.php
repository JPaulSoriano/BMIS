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

    public function locations()
    {
        return $this->belongsToMany('App\Location');
    }
}
