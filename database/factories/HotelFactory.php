<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Hotel;
use Faker\Generator as Faker;

$factory->state(Hotel::class, 'seeding', function (Faker $faker) {
    $storage_path = Storage::disk()->getAdapter()->getPathPrefix() ;
    return [
        'image_name' => $faker->file(storage_path('app/default_images'), $storage_path . 'app/images/hotels', false)
    ];
});

$factory->define(Hotel::class, function (Faker $faker) {
    return [
        'name' => $this->faker->city ." hotel",
        'address' => $this->faker->address,
        'city' => $this->faker->city,
        'state' => $this->faker->state,
        'country' => $this->faker->country,
        'zip_code' => $this->faker->postcode,
        'phone_number' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
        'image_name' => ''
    ];
});

