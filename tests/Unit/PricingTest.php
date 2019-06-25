<?php

namespace Tests\Unit;

use App\Pricing;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PricingTest extends TestCase
{
    /**
     * save Pricing Test.
     * @test
     * @return void
     */
    public function it_can_create_a_pricing_option()
    {
        $fake_pricing_data = factory(Pricing::class)->make()->toArray();

        $this->post(route('pricings.store'), $fake_pricing_data)
            ->assertStatus(201)
            ->assertJson($fake_pricing_data);
    }

    /**
     * show Pricing Test.
     * @test
     * @return void
     */
    public function it_can_show_a_pricing_option()
    {
        $fake_pricing = factory(Pricing::class)->create();
        $this->assertDatabaseHas('pricings', $fake_pricing->toArray());
        $this->get(route('pricings.show', ['pricing_id' => $fake_pricing->id]))
            ->assertStatus(200)
            ->assertJson($fake_pricing->toArray());

    }

    /**
     * update Pricing Test.
     * @test
     * @return void
     */
    public function it_can_update_a_pricing_option()
    {
        $fake_pricing = factory(Pricing::class)->create();
        $new_pricing_data = [
            'rack_rate' => 520.56
        ];
        $this->put(route('pricings.update', ['pricing_id' => $fake_pricing->id]), $new_pricing_data)
            ->assertStatus(200)
            ->assertJson($new_pricing_data);

    }

    /**
     * delete RoomType Test.
     * @test
     * @return void
     */
    public function it_can_delete_a_pricing_option() {
        $fake_pricing = factory(Pricing::class)->create();
        $this->delete(route('pricings.destroy', ['pricing_id' => $fake_pricing->id]))
            ->assertStatus(200);
        $this->assertDatabaseMissing('pricings', ['id' => $fake_pricing->id]);
    }
}
