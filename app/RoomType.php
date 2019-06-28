<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function pricing()
    {
        return $this->hasOne('App\Pricing','room_type_id');
    }
}
