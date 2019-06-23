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
    public function it_can_create_an_hotel()
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
}
