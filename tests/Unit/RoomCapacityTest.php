<?php

namespace Tests\Unit;

use App\RoomCapacity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomCapacityTest extends TestCase
{
    /**
     * save RoomCapacity Test.
     * @test
     * @return void
     */
    public function it_can_create_a_room_capacity()
    {
        $fake_room_capacity_data = [
            'name' => 'Double'
        ];

        $this->post(route('room_capacities.store'), $fake_room_capacity_data)
            ->assertStatus(201)
            ->assertJson($fake_room_capacity_data);
    }

    /**
     * show RoomCapacity Test.
     * @test
     * @return void
     */
    public function it_can_show_a_room_capacity()
    {
        $fake_room_capacity = factory(RoomCapacity::class)->create();
        $this->assertDatabaseHas('room_capacities', $fake_room_capacity->toArray());
        $this->get(route('room_capacities.show', ['room_capacity_id' => $fake_room_capacity->id]))
            ->assertStatus(200)
            ->assertJson($fake_room_capacity->toArray());

    }

    /**
     * update RoomCapacity Test.
     * @test
     * @return void
     */
    public function it_can_update_a_room_capacity()
    {
        $fake_room_capacity = factory(RoomCapacity::class)->create();
        $new_room_capacity_data = [
            'name' => 'deluxe'
        ];
        $this->put(route('room_capacities.update', ['room_capacity_id' => $fake_room_capacity->id]), $new_room_capacity_data)
            ->assertStatus(200)
            ->assertJson($new_room_capacity_data);

    }

    /**
     * delete RoomCapacity Test.
     * @test
     * @return void
     */
    public function it_can_delete_a_room_capacity() {
        $fake_room_capacity = factory(RoomCapacity::class)->create();
        $this->delete(route('room_capacities.destroy', ['room_capacity_id' => $fake_room_capacity->id]))
            ->assertStatus(200);
        $this->assertDatabaseMissing('room_capacities', ['id' => $fake_room_capacity->id]);
    }
}
