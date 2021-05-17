<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(BusCompanyProfile::class, 'company_id');
    }
}
