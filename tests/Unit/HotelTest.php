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
        $fakeHotelData = factory(Hotel::class)->make()->toArray();

        $this->post(route('hotels.store'), $fakeHotelData)
            ->assertStatus(201)
            ->assertJson($fakeHotelData);
    }

    /**
     * show Hotels Test.
     * @test
     * @return void
     */
    public function it_can_show_hotel_details()
    {
        $fakeHotel = factory(Hotel::class)->create();
        $this->assertDatabaseHas('hotels', $fakeHotel->toArray());
        $this->get(route('hotels.show', ['hotel_id' => $fakeHotel->id]))
            ->assertStatus(200)
            ->assertJson($fakeHotel->toArray());

    }

    /**
     * show Hotels Test.
     * @test
     * @return void
     */
    public function it_can_update_a_hotel()
    {
        $fakeHotel = factory(Hotel::class)->create();
        $newHotelData = [
            'name' => $this->faker->city ." hotel",
            'country' => $this->faker->country
        ];
        $this->put(route('hotels.update', ['hotel_id' => $fakeHotel->id]), $newHotelData)
            ->assertStatus(200)
            ->assertJson($newHotelData);

    }
}
