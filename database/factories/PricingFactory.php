<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Pricing;
use Faker\Generator as Faker;

$factory->define(Pricing::class, function (Faker $faker) {
    return [
        'rack_rate' => $this->faker->randomFloat(0, 100, 15000),
        'min_stay_length' => $this->faker->numberBetween(1, 3),
        'max_stay_length' => $this->faker->numberBetween(1, 25),
        'services_included' => $this->faker->sentence(5, true),
        'room_type_id' => function() {
            $room_type = \App\RoomType::firstOrCreate([], factory(\App\RoomType::class)->make()->toArray());

            return $room_type->id;
        }
    ];
});
