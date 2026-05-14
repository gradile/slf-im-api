<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'language', 'consent1', 'consent2',
    ];

    protected $casts = [
        'consent1' => 'boolean',
        'consent2' => 'boolean',
    ];
}
