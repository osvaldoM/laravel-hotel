<?php

use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Hotel::class)->state('seeding')->create(['name' => 'The Codeline Hotel']);
    }
}
