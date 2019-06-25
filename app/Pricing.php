<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = [
        'rack_rate',
        'max_stay_length',
        'min_stay_length',
        'services_included',
        'room_type_id'
    ];
}
