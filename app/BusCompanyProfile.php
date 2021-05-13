<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusCompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'company_address', 'company_contact', 'company_mission', 'company_profile', 'activate_point'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class, 'company_id');
    }

    public function busClasses()
    {
        return $this->hasMany(BusClass::class, 'company_id');
    }

    public function terminals()
    {
        return $this->hasMany(Terminal::class, 'company_id');
    }

    public function routes()
    {
        return $this->hasMany(Route::class, 'company_id');
    }

    public function rides()
    {
        return $this->hasMany(Ride::class, 'company_id');
    }
}
