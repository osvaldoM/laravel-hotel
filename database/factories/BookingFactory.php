<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'room_id' => function() {
            $room = \App\Room::firstOrCreate([], factory(\App\Room::class)->make()->toArray());

            return $room->id;
        },
        'start_date' => $faker->dateTimeThisMonth('+ 25 days')->format('Y-m-d H:i:s'),
        'end_date' =>  function($booking) {
            $start_date = \Carbon\Carbon::parse($booking['start_date']);
            return $start_date->addDays($this->faker->numberBetween(1,4))->toDateTimeString();
        },
        'customer_full_name' => $faker->name,
        'customer_email' => $faker->email,
        'user_id' => function() {
            $user_data = factory(\App\User::class)->make()->makeVisible(['password', 'remember_token']);

            $user = \App\User::firstOrCreate([], $user_data->toArray());

            return $user->id;
        }


    ];
});
