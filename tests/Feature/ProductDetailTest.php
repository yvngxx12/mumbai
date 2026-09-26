<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_shows_full_information(): void
    {
        $this->seed();

        $product = Product::where('slug', 'urban-black')
            ->with(['colors', 'sizes'])
            ->firstOrFail();

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee($product->name);
        $response->assertSee(shop_price($product->price));
        $response->assertSee('Talle');
        $response->assertSee('Color');
        $response->assertSee('Comprar');
        $response->assertSee('El sistema de pagos estará disponible próximamente.');

        foreach ($product->sizes as $size) {
            $response->assertSee($size->name);
        }
    }

    public function test_product_detail_shows_an_image_per_color(): void
    {
        $this->seed();

        $product = Product::where('slug', 'urban-black')
            ->with('colors')
            ->firstOrFail();

        $response = $this->get(route('products.show', $product));

        $response->assertOk();

        foreach ($product->colors as $color) {
            $response->assertSee('data-color-name="'.$color->name.'"', false);
        }

        $response->assertSee('data-gallery-main');
    }

    public function test_unknown_product_returns_404(): void
    {
        $this->get('producto/999999')->assertNotFound();
    }
}
