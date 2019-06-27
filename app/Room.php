<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'hotel_id',
        'room_type_id',
        'room_capacity_id',
        'image_name'
    ];
}
