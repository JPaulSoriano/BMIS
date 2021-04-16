<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusCompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'company_address', 'company_contact', 'company_mission', 'company_profile',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id');
    }
}
