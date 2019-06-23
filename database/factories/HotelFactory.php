<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Hotel;
use Faker\Generator as Faker;

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
        'image' => $this->faker->word
    ];
});
