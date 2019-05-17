<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersListTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function get_orders_list()
    {
        $fake = factory(\App\Order::class)->create();

        $response = $this->get('/orders');
        $response->assertOk()
            ->assertSee($fake->customer_name)
            ->assertSee($fake->amount)
            ->assertSee($fake->status);
    }

    /** @test */
    public function show_order_detail()
    {
        $fake = factory(\App\Order::class)->create();

        $response = $this->get('/orders/' . $fake->id);
        $response->assertOk()
            ->assertSee($fake->id)
            ->assertSee($fake->status)
            ->assertSee($fake->amount);
    }
}
