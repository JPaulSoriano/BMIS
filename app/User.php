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

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function terminals()
    {
        return $this->hasMany(Terminal::class);
    }

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(BusCompanyProfile::class);
    }

    public function employeeProfile()
    {
        return $this->hasOne(Employee::class);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function passengerProfile()
    {
        return $this->hasOne(PassengerProfile::class, 'passenger_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
