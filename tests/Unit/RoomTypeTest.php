<?php

namespace Tests\Unit;

use App\RoomType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTypeTest extends TestCase
{
    /**
     * save RoomType Test.
     * @test
     * @return void
     */
    public function it_can_create_a_room_type()
    {
        $fake_room_type_data = [
            'name' => 'Double'
        ];

        $this->post(route('room_types.store'), $fake_room_type_data)
            ->assertStatus(201)
            ->assertJson($fake_room_type_data);
    }

    /**
     * show RoomType Test.
     * @test
     * @return void
     */
    public function it_can_show_a_room_type()
    {
        $fake_room_type = factory(RoomType::class)->create();
        $this->assertDatabaseHas('room_types', $fake_room_type->toArray());
        $this->get(route('room_types.show', ['room_type_id' => $fake_room_type->id]))
            ->assertStatus(200)
            ->assertJson($fake_room_type->toArray());

    }

    /**
     * update RoomType Test.
     * @test
     * @return void
     */
    public function it_can_update_a_room_type()
    {
        $fake_room_type = factory(RoomType::class)->create();
        $new_room_type_data = [
            'name' => 'deluxe'
        ];
        $this->put(route('room_types.update', ['room_type_id' => $fake_room_type->id]), $new_room_type_data)
            ->assertStatus(200)
            ->assertJson($new_room_type_data);

    }

    /**
     * delete RoomType Test.
     * @test
     * @return void
     */
    public function it_can_delete_a_room_type() {
        $fake_room_type = factory(RoomType::class)->create();
        $this->delete(route('room_types.destroy', ['room_type_id' => $fake_room_type->id]))
            ->assertStatus(200);
        $this->assertDatabaseMissing('room_types', ['id' => $fake_room_type->id]);
    }

}
