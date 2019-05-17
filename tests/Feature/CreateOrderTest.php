<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_welcome_page()
    {
        $response = $this->get('/');
        $response
            ->assertOk()
            ->assertSee('Si, deseo comprarlo!');
    }

    /** @test */
    public function create_order()
    {
        $fake = factory(\App\Order::class)->make(['id' => 1]);

        $response = $this->post(route('order-generate'), [
            "name" => $fake->customer_name,
            "email" => $fake->customer_email,
            "phone" => $fake->customer_mobile
        ]);

        $response->assertStatus(302) // redirect
                ->assertSee('Redirecting to')
                ->assertSee('https://dev.placetopay.com/redirection/session/');
    }

    /** @test */
    public function pending_order()
    {
        $this->create_order(); // id: 1

        $response = $this->get('/orders/1');
        $response->assertOk()
            ->assertSeeText('Orden #1')
            ->assertSeeText('Estado: PENDING')
            ->assertSee('PAGAR');
    }
}
