<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'hotel_id',
        'room_type_id',
        'image_name'
    ];

    public function roomType() {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}
