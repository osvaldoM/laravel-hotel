<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'start_date',
        'end_date',
        'customer_full_name',
        'customer_email',
        'user_id'
    ];
}
