<?php

namespace Tests\Unit;

use App\Booking;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    /**
     * save Booking Test.
     * @test
     * @return void
     */
    public function it_can_create_a_booking()
    {
        $fake_booking_data = factory(Booking::class)->make()->toArray();

        $this->post(route('bookings.store'), $fake_booking_data)
            ->assertStatus(201)
            ->assertJson($fake_booking_data)
        ->content();
    }

    /**
     * show Booking Test.
     * @test
     * @return void
     */
    public function it_can_show_a_booking()
    {
        $fake_booking = factory(Booking::class)->create();
        $this->assertDatabaseHas('bookings', $fake_booking->toArray());
        $this->get(route('bookings.show', ['booking_id' => $fake_booking->id]))
            ->assertStatus(200)
            ->assertJson($fake_booking->toArray());

    }

    /**
     * update Booking Test.
     * @test
     * @return void
     */
    public function it_can_update_a_booking()
    {
        $fake_booking = factory(Booking::class)->create();
        $new_booking_data = [
            'customer_email' => $this->faker->email
        ];
        $this->put(route('bookings.update', ['booking_id' => $fake_booking->id]), $new_booking_data)
            ->assertStatus(200)
            ->assertJson($new_booking_data);

    }

    /**
     * delete Booking Test.
     * @test
     * @return void
     */
    public function it_can_delete_a_booking() {
        $fake_booking = factory(Booking::class)->create();
        $this->delete(route('bookings.destroy', ['booking_id' => $fake_booking->id]))
            ->assertStatus(200);
        $this->assertDatabaseMissing('bookings', ['id' => $fake_booking->id]);
    }

}
