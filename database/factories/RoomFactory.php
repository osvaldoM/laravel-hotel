<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Room;
use Faker\Generator as Faker;


$hotel_id = $factory->create(\App\Hotel::class)->id;
$factory->define(Room::class, function (Faker $faker) use ($hotel_id) {
    return [
        'name' => $this->faker->regexify('[A-Z]+[0-9]'),
        'image_name' => $this->faker->word . '.' . $this->faker->randomElement(['jpg', 'png', 'jpeg', 'bmp', 'gif', 'gif', 'svg']),
        'hotel_id' => function () {
            // we don't need more than one hotel in the DB , so we get the first record if it exists or create a new one;
            $hotel = \App\Hotel::firstOrCreate([], factory(\App\Hotel::class)->make()->toArray());

            return $hotel->id;
        },
        'room_type_id' => function () {
            // ensure there are no two room types with the same name;
            $room_type_data = factory(\App\RoomType::class)->make();
            $room_type = \App\RoomType::firstOrCreate(['name' => $room_type_data->name], $room_type_data->toArray());

            return $room_type->id;
        },
        'room_capacity_id' => function () {
            $room_capacity_data = factory(\App\RoomCapacity::class)->make();
            $room_capacity = \App\RoomCapacity::firstOrCreate(['name' => $room_capacity_data->name], $room_capacity_data->toArray());

            return $room_capacity->id;
        }
    ];
});
