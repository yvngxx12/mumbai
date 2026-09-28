<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_the_catalog_with_seeded_products(): void
    {
        $this->seed();

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Colección');
        $response->assertSee(Product::count().' productos');
        $response->assertSee('Urban Black');
        $response->assertSee('Nocturne');
    }

    public function test_product_page_shows_front_and_back_for_products_with_both_sides(): void
    {
        $this->seed();

        $this->get(route('products.show', ['pant']))
            ->assertOk()
            ->assertSee('Ver parte trasera')
            ->assertSee('pant-blanco-adelante.png')
            ->assertSee('pant-blanco-atras.png');
    }

    public function test_catalog_links_to_each_product_detail(): void
    {
        $this->seed();

        $product = Product::where('slug', 'urban-black')->firstOrFail();

        $this->get(route('home'))
            ->assertSee(route('products.show', $product), false);
    }

    public function test_catalog_shows_the_configured_currency(): void
    {
        $this->seed();

        $this->get(route('home'))->assertSee(config('shop.currency'));
    }
}
