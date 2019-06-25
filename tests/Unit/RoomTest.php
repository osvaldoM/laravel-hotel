<?php

namespace Tests\Unit;

use App\Room;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
{
    /**
     * save Room Test.
     * @test
     * @return void
     */
    public function it_can_create_a_room()
    {
        $fake_room_data = factory(Room::class)->make()->toArray();

        $this->post(route('rooms.store'), $fake_room_data)
            ->assertStatus(201)
            ->assertJson($fake_room_data);
    }

    /**
     *  show Room Test
     * @test
     * @return void
     */
    public function it_can_show_a_room()
    {
        $fake_room = factory(Room::class)->create();
        $this->assertDatabaseHas('rooms', $fake_room->toArray());

        $this->get(route('rooms.show', ['room_id' => $fake_room->id]))
            ->assertStatus(200)
            ->assertJson($fake_room->toArray());
    }

    /**
     * update Room Test.
     * @test
     * @return void
     */
    public function it_can_update_a_room()
    {
        $fake_room = factory(Room::class)->create();
        $new_room_data = [
            'name' => 'A2'
        ];
        $this->put(route('rooms.update', ['room_id' => $fake_room->id]), $new_room_data)
            ->assertStatus(200)
            ->assertJson($new_room_data);
    }

    /**
     * delete Room Test.
     * @test
     * @return void
     */
    public function it_can_delete_a_room() {
        $fake_room = factory(Room::class)->create();
        $this->delete(route('rooms.destroy', ['room_id' => $fake_room->id]))
            ->assertStatus(200);
        $this->assertDatabaseMissing('rooms', ['id' => $fake_room->id]);
    }

}
