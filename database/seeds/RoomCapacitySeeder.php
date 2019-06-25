<?php

use Illuminate\Database\Seeder;

class RoomCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_capacities')->insert([
            [
                'name' => 'Single'
            ],
            [
                'name' => 'Double'
            ],
            [
                'name' => 'Family'
            ]
        ]);
    }
}
