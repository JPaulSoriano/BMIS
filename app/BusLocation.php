<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id', 'conductor_id', 'longitude', 'latitude'
    ];
}
