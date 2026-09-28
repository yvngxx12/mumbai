<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['email' => 'admin@mumbai.com']);
    }

    private function loginAsAdmin(): void
    {
        $this->createAdmin();
        $this->post(route('login.store'), [
            'email' => 'admin@mumbai.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_login_page_is_rendered(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Acceso administrador');
    }

    public function test_admin_can_see_dashboard(): void
    {
        $this->loginAsAdmin();

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Panel');
    }

    public function test_admin_can_open_management_pages(): void
    {
        $this->loginAsAdmin();

        $this->get(route('admin.products.index'))->assertOk();
        $this->get(route('admin.products.create'))->assertOk()->assertSee('Colores e imágenes');
        $this->get(route('admin.colors.index'))->assertOk()->assertSee('Nuevo color');
        $this->get(route('admin.sizes.index'))->assertOk()->assertSee('Nuevo talle');

        $product = Product::factory()->create();
        $this->get(route('admin.products.edit', $product))->assertOk();
    }

    public function test_admin_can_create_a_product(): void
    {
        $this->loginAsAdmin();

        $color = Color::factory()->create();
        $size = Size::factory()->create();

        $this->post(route('admin.products.store'), [
            'name' => 'Tee de prueba',
            'type' => 'Básica',
            'description' => 'Una remera de prueba.',
            'price' => 19999,
            'stock' => 10,
            'colors' => [$color->id],
            'sizes' => [$size->id],
        ])->assertRedirect();

        $this->assertDatabaseHas('products', [
            'name' => 'Tee de prueba',
            'slug' => 'tee-de-prueba',
        ]);

        $this->assertDatabaseHas('color_product', [
            'color_id' => $color->id,
        ]);
    }

    public function test_admin_can_update_a_product(): void
    {
        $this->loginAsAdmin();

        $product = Product::factory()->create();

        $this->put(route('admin.products.update', $product), [
            'name' => 'Nombre nuevo',
            'type' => 'Oversize',
            'description' => 'Descripción cambiada.',
            'price' => 21000,
            'stock' => 5,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Nombre nuevo',
            'slug' => 'nombre-nuevo',
            'price' => 21000,
        ]);
    }

    public function test_admin_can_delete_a_product(): void
    {
        $this->loginAsAdmin();

        $product = Product::factory()->create();

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_can_manage_colors(): void
    {
        $this->loginAsAdmin();

        $this->post(route('admin.colors.store'), ['name' => 'Violeta', 'hex' => '#7c3aed'])
            ->assertRedirect();

        $this->assertDatabaseHas('colors', ['name' => 'Violeta', 'hex' => '#7c3aed']);
    }

    public function test_admin_can_manage_sizes(): void
    {
        $this->loginAsAdmin();

        $this->post(route('admin.sizes.store'), ['name' => 'XXXL', 'sort' => 7])
            ->assertRedirect();

        $this->assertDatabaseHas('sizes', ['name' => 'XXXL', 'sort' => 7]);
    }

    public function test_admin_uploading_a_product_image_stores_public_path(): void
    {
        Storage::fake('uploads');

        $this->loginAsAdmin();

        $this->post(route('admin.products.store'), [
            'name' => 'Tee con foto',
            'type' => 'Básica',
            'description' => 'Con imagen subida.',
            'price' => 25000,
            'stock' => 3,
            'image' => UploadedFile::fake()->image('foto.jpg'),
        ])->assertRedirect();

        $product = Product::where('slug', 'tee-con-foto')->first();

        $this->assertNotNull($product);
        $this->assertStringStartsWith('storage/products/', $product->image);

        Storage::disk('uploads')->assertExists(Str::after($product->image, 'storage/'));
    }

    public function test_deleting_a_product_removes_its_uploaded_image(): void
    {
        Storage::fake('uploads');

        $this->loginAsAdmin();

        $product = Product::factory()->create(['image' => 'storage/products/prueba.jpg']);
        Storage::disk('uploads')->put('products/prueba.jpg', 'contenido');

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        Storage::disk('uploads')->assertMissing('products/prueba.jpg');
    }

    public function test_admin_can_upload_a_back_image_for_a_color(): void
    {
        Storage::fake('uploads');

        $this->loginAsAdmin();

        $color = Color::factory()->create();

        $this->post(route('admin.products.store'), [
            'name' => 'Frente y espalda',
            'type' => 'Básica',
            'description' => 'Con las dos partes.',
            'price' => 26000,
            'stock' => 4,
            'colors' => [$color->id],
            'color_images' => [$color->id => UploadedFile::fake()->image('front.jpg')],
            'color_images_back' => [$color->id => UploadedFile::fake()->image('back.jpg')],
        ])->assertRedirect();

        $product = Product::where('slug', 'frente-y-espalda')->first();

        $this->assertNotNull($product);
        $this->assertStringStartsWith('storage/products/', $product->imageForColor($color));
        $this->assertStringStartsWith('storage/products/', $product->backImageForColor($color));

        Storage::disk('uploads')->assertExists(Str::after($product->backImageForColor($color), 'storage/'));
    }

    public function test_edit_form_shows_the_back_image_of_a_color(): void
    {
        $this->loginAsAdmin();

        $color = Color::factory()->create();
        $product = Product::factory()->create();
        $product->colors()->sync([
            $color->id => ['image' => 'storage/products/front.jpg', 'image_back' => 'storage/products/back.jpg'],
        ]);

        $this->get(route('admin.products.edit', $product))
            ->assertOk()
            ->assertSee('Quitar trasera')
            ->assertSee('Imagen trasera (opcional)');
    }

    public function test_deleting_a_product_removes_color_back_images(): void
    {
        Storage::fake('uploads');

        $this->loginAsAdmin();

        $color = Color::factory()->create();
        $product = Product::factory()->create();
        $product->colors()->sync([
            $color->id => ['image' => 'storage/products/front.jpg', 'image_back' => 'storage/products/back.jpg'],
        ]);
        Storage::disk('uploads')->put('products/back.jpg', 'contenido');

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        Storage::disk('uploads')->assertMissing('products/back.jpg');
    }
}
