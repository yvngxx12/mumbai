<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function makeProduct(int $price = 20000): Product
    {
        $color = Color::factory()->create(['name' => 'Negro']);
        $size = Size::factory()->create(['name' => 'M', 'sort' => 1]);

        $product = Product::factory()->create([
            'name' => 'Tee Test',
            'slug' => 'tee-test',
            'price' => $price,
        ]);

        $product->colors()->attach($color);
        $product->sizes()->attach($size);

        return $product;
    }

    public function test_checkout_page_shows_variant_deposit_and_bank_details(): void
    {
        $product = $this->makeProduct();

        $this->get(route('checkout.create', ['product' => $product, 'color' => 'Negro', 'size' => 'M']))
            ->assertOk()
            ->assertSee('Confirmá tu compra')
            ->assertSee('Nombre')
            ->assertSee('Apellido')
            ->assertSee('Número de teléfono')
            ->assertSee('AR$ 10.000,00')
            ->assertSee('Seña a abonar (50%)')
            ->assertSee(config('shop.checkout.cvu'))
            ->assertSee(config('shop.checkout.alias'))
            ->assertSee(config('shop.checkout.drop_date'))
            ->assertSee('Confirmar compra')
            ->assertSee('WhatsApp 1')
            ->assertSee('WhatsApp 2');
    }

    public function test_checkout_redirects_back_without_a_valid_variant(): void
    {
        $product = $this->makeProduct();

        $this->get(route('checkout.create', $product))
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHas('checkout_error');

        $this->get(route('checkout.create', ['product' => $product, 'color' => 'Rosa', 'size' => 'M']))
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHas('checkout_error');
    }

    public function test_checkout_creates_a_pending_order(): void
    {
        $product = $this->makeProduct();

        $this->post(route('checkout.store', $product), [
            'name' => 'Juan',
            'surname' => 'Perez',
            'phone' => '1155555555',
            'color' => 'Negro',
            'size' => 'M',
        ])->assertRedirect();

        $order = Order::firstOrFail();

        $this->assertSame(config('shop.brand').'-0001', $order->order_number);
        $this->assertSame('Juan Perez', $order->customer_name);
        $this->assertSame('1155555555', $order->customer_phone);
        $this->assertSame('Tee Test', $order->product_name);
        $this->assertSame('Negro', $order->color_name);
        $this->assertSame('M', $order->size_name);
        $this->assertSame(20000.0, $order->unit_price);
        $this->assertSame(10000.0, $order->deposit);
        $this->assertSame('pending', $order->status->value);

        $this->get(route('checkout.confirmation', $order))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('AR$ 10.000,00')
            ->assertSee(config('shop.checkout.cvu'))
            ->assertSee('wa.me/', false);
    }

    public function test_checkout_rejects_an_invalid_variant(): void
    {
        $product = $this->makeProduct();

        $this->post(route('checkout.store', $product), [
            'name' => 'Juan',
            'surname' => 'Perez',
            'phone' => '1155555555',
            'color' => 'Rosa',
            'size' => 'M',
        ])->assertSessionHasErrors('color');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_product_page_sends_the_selected_variant_to_checkout(): void
    {
        $this->seed();

        $this->get(route('products.show', ['12s']))
            ->assertOk()
            ->assertSee('data-product-slug="12s"', false);
    }

    public function test_confirmation_page_shows_whatsapp_with_the_order_data(): void
    {
        $order = Order::factory()->create([
            'order_number' => 'MUMBAI-0042',
            'product_name' => 'Tee Test',
            'color_name' => 'Negro',
            'size_name' => 'M',
            'unit_price' => 20000,
            'deposit' => 10000,
        ]);

        $response = $this->get(route('checkout.confirmation', $order));

        $response->assertOk()
            ->assertSee('MUMBAI-0042')
            ->assertSee('Enviar comprobante por WhatsApp');

        foreach (config('shop.checkout.whatsapp') as $waNumber => $waLabel) {
            $response->assertSee('wa.me/'.$waNumber, false)
                ->assertSee($waLabel);
        }
    }
}
