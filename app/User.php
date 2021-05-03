<?php

namespace App;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function companyProfile()
    {
        return $this->hasOne(BusCompanyProfile::class);
    }

    // public function buses()
    // {
    //     return $this->hasManyThrough(Bus::class, BusCompanyProfile::class, 'user_id', 'company_id');
    // }

    // public function busClasses()
    // {
    //     return $this->hasManyThrough(BusClass::class, BusCompanyProfile::class, 'user_id', 'company_id');
    // }

    // public function terminals()
    // {
    //     return $this->hasManyThrough(Terminal::class, BusCompanyProfile::class, 'user_id', 'company_id');
    // }

    // public function routes()
    // {
    //     return $this->hasManyThrough(Route::class, BusCompanyProfile::class, 'user_id', 'company_id');
    // }

    // public function rides()
    // {
    //     return $this->hasManyThrough(Ride::class, BusCompanyProfile::class, 'user_id', 'company_id');
    // }

    public function employeeProfile()
    {
        return $this->hasOne(Employee::class);
    }

    public function passengerProfile()
    {
        return $this->hasOne(PassengerProfile::class, 'passenger_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'passenger_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'passenger_id');
    }

    public function busLocation()
    {
        return $this->hasOne(BusLocation::class, 'conductor_id');
    }

    public function conductorHistory()
    {
        return $this->hasMany(ConductorHistory::class, 'conductor_id');
    }
}
