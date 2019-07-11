<?php

namespace Tests\Unit;

use App\Room;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $images_folder_path = 'images/rooms/';
        $fake_room_data = factory(Room::class)->make()->toArray();

        $image_to_upload = UploadedFile::fake()->image('');
        $file_name = $image_to_upload->hashName();
        $fake_room_data['image_url'] = route('rooms.image', $file_name);;
        $this->post(route('rooms.store'), array_merge($fake_room_data, ['image' => $image_to_upload]))
            ->assertStatus(201)
            ->assertJson($fake_room_data);
        Storage::disk('local')->assertExists("$images_folder_path$file_name");
    }

    /**
     *  show Room Test
     * @test
     * @return void
     */
    public function it_can_show_a_room()
    {
        $fake_room = factory(Room::class)->create();
        $this->assertDatabaseHas('rooms', $fake_room->makeHidden('image_url')->toArray());

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
