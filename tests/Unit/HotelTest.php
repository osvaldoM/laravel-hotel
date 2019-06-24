<?php

namespace Tests\Unit;

use App\Hotel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HotelTest extends TestCase
{
    /**
     * save Hotels Test.
     * @test
     * @return void
     */
    public function it_can_create_a_hotel()
    {
        $fake_hotel_data = factory(Hotel::class)->make()->toArray();

        $this->post(route('hotels.store'), $fake_hotel_data)
            ->assertStatus(201)
            ->assertJson($fake_hotel_data);
    }

    /**
     * show Hotels Test.
     * @test
     * @return void
     */
    public function it_can_show_hotel_details()
    {
        $fake_hotel = factory(Hotel::class)->create();
        $this->assertDatabaseHas('hotels', $fake_hotel->toArray());
        $this->get(route('hotels.show', ['hotel_id' => $fake_hotel->id]))
            ->assertStatus(200)
            ->assertJson($fake_hotel->toArray());

    }

    /**
     * update Hotels Test.
     * @test
     * @return void
     */
    public function it_can_update_a_hotel()
    {
        $fake_hotel = factory(Hotel::class)->create();
        $new_hotel_data = [
            'name' => $this->faker->city ." hotel",
            'country' => $this->faker->country
        ];
        $this->put(route('hotels.update', ['hotel_id' => $fake_hotel->id]), $new_hotel_data)
            ->assertStatus(200)
            ->assertJson($new_hotel_data);

    }
}
