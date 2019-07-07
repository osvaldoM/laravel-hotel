<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([HotelSeeder::class, UserSeeder::class, RoomTypeSeeder::class, PricingSeeder::class, RoomSeeder::class, BookingSeeder::class]);
    }
}
