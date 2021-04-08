<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'terminal_name', 'terminal_address', 'user_id'
    ];

    public function routes()
    {
        return $this->belongsToMany('App\Route');

    }

}
