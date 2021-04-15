<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'route_id', 'bus_id', 'ride_date', 'departure_time', 'auto_confirm', 'ride_type'
    ];

    protected $dates = [
        'ride_date', 'departure_time'
    ];

    public function schedule()
    {
        return $this->hasOne(RideSchedule::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function getRunningDaysAttribute(): array
    {
        return collect(Carbon::getDays())
            ->reject(fn($day) => $this->schedule->attributes[strtolower($day)] == 0)
            ->toArray();
    }

    public function isCyclic()
    {
        return !isset($this->attributes['ride_date']);
    }

    public function isActive() : bool
    {
        return ($this->ride_date > Carbon::today()
            || ($this->ride_date == Carbon::today() && $this->departure_time > Carbon::now())
            || ($this->isCyclic() && (
                    optional($this->schedule)->end_date > Carbon::today()
                    || is_null(optional($this->schedule)->end_date)
                    || (optional($this->schedule)->end_date == Carbon::today() && $this->departure_time > Carbon::now())
                )
            ));
    }
}
