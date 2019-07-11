<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'phone_number',
        'email',
        'image_name' //remove this
    ];
    protected $appends = ['image_url'];
    protected $hidden = ['image_name'];

    public function getImageUrlAttribute() {
        return route('hotels.image', $this->attributes['image_name']);
    }
}
