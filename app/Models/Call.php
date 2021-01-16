<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
        'customer_id',
        'call_date',
        'phone_number',
        'ip',
        'continent_code',
        'duration'
    ];

    public $timestamps = false;
}