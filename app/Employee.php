<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'contact', 'address', 'user_id', 'employee_no'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyProfile()
    {
        return $this->belongsTo(BusCompanyProfile::class, 'company_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
