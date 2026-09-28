<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): void
    {
        User::factory()->create(['email' => 'admin@mumbai.com']);

        $this->post(route('login.store'), [
            'email' => 'admin@mumbai.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_guest_is_redirected_from_orders(): void
    {
        $this->get(route('admin.orders.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_see_the_orders_list(): void
    {
        $this->loginAsAdmin();

        Order::factory()->create([
            'order_number' => 'MUMBAI-0001',
            'customer_name' => 'Juan Perez',
            'customer_phone' => '1155555555',
            'product_name' => 'Tee Test',
            'color_name' => 'Negro',
            'size_name' => 'M',
        ]);

        $this->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Compras')
            ->assertSee('MUMBAI-0001')
            ->assertSee('Juan Perez')
            ->assertSee('1155555555')
            ->assertSee('Tee Test')
            ->assertSee('Pendiente');
    }

    public function test_admin_can_accept_a_pending_order(): void
    {
        $this->loginAsAdmin();

        $order = Order::factory()->create(['order_number' => 'MUMBAI-0001']);

        $this->post(route('admin.orders.accept', $order))
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertSame('confirmed', $order->refresh()->status->value);
    }

    public function test_admin_can_cancel_a_pending_order(): void
    {
        $this->loginAsAdmin();

        $order = Order::factory()->create(['order_number' => 'MUMBAI-0001']);

        $this->post(route('admin.orders.cancel', $order))
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertSame('cancelled', $order->refresh()->status->value);
    }

    public function test_admin_accept_does_not_override_a_cancelled_order(): void
    {
        $this->loginAsAdmin();

        $order = Order::factory()->cancelled()->create(['order_number' => 'MUMBAI-0001']);

        $this->post(route('admin.orders.accept', $order));

        $this->assertSame('cancelled', $order->refresh()->status->value);
    }

    public function test_admin_orders_can_be_filtered_by_status(): void
    {
        $this->loginAsAdmin();

        Order::factory()->create(['order_number' => 'MUMBAI-0001', 'status' => 'pending']);
        Order::factory()->confirmed()->create(['order_number' => 'MUMBAI-0002']);

        $this->get(route('admin.orders.index', ['status' => 'confirmed']))
            ->assertOk()
            ->assertSee('MUMBAI-0002')
            ->assertDontSee('MUMBAI-0001');
    }
}
