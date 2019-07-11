<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Room;
use Faker\Generator as Faker;


$factory->define(Room::class, function (Faker $faker) {
    return [
        'name' => $this->faker->regexify('[A-Z]+[0-9]'),
        'image_name' => '',
        'hotel_id' => function () {
            // we don't need more than one hotel in the DB , so we get the first record if it exists or create a new one;
            $hotel = \App\Hotel::firstOrCreate([], factory(\App\Hotel::class)->make()->makeHidden('image_url')->toArray());

            return $hotel->id;
        },
        'room_type_id' => function () {
            // ensure there are no two room types with the same name;
            $room_type_data = factory(\App\RoomType::class)->make();
            $room_type = \App\RoomType::firstOrCreate(['name' => $room_type_data->name], $room_type_data->toArray());

            return $room_type->id;
        }
    ];
});

$factory->state(Room::class, 'seeding', function (Faker $faker) {
    $storage_path = Storage::disk()->getAdapter()->getPathPrefix() ;
    return [
        'image' => $faker->file(storage_path('app/default_images'), $storage_path . 'app/images/rooms', false)
    ];
});
