<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date', 'end_date', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
