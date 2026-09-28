<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => '12S',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => '12S 2',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'BIRKI',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'DUBAI',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'DUSK',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'GANG',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'KILLBILL',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'MUMBAI',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'MUMBAI III',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'MUMBAI IIII',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'MUMBAI 2',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'PANT',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'STREET',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'TOUR',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro', 'Blanco/Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'WILD',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
            [
                'name' => 'YOUNG',
                'type' => 'Básica',
                'price' => 22900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Producto de la colección Mumbai.',
            ],
        ];

        foreach ($products as $data) {
            $slug = str()->slug($data['name']);

            $pivot = [];
            $primaryImage = null;

            foreach ($data['colors'] as $colorName) {
                $color = Color::where('name', $colorName)->first();

                if ($color === null) {
                    continue;
                }

                $baseName = "{$slug}-".self::colorSlug($colorName);
                $image = self::photoFor("{$baseName}-adelante")
                    ?? self::photoFor($baseName)
                    ?? "images/products/{$baseName}.svg";
                $back = self::photoFor("{$baseName}-atras");
                $pivot[$color->id] = ['image' => $image, 'image_back' => $back];
                $primaryImage ??= $image;
            }

            $primaryImage = self::photoFor($slug) ?? $primaryImage;

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'type' => $data['type'],
                    'price' => $data['price'],
                    'image' => $primaryImage,
                    'stock' => $data['stock'],
                ],
            );

            $product->colors()->sync($pivot);

            $product->sizes()->sync(
                Size::whereIn('name', $data['sizes'])->orderBy('sort')->pluck('id'),
            );
        }
    }

    /**
     * Devuelve la primera foto (jpg/jpeg/png/webp/gif) encontrada en el repo
     * para el nombre base dado, o null si no existe ninguna.
     */
    private static function photoFor(string $baseName): ?string
    {
        $dir = public_path('images/products');

        foreach (['jpg', 'jpeg', 'png', 'webp', 'gif'] as $ext) {
            if (file_exists($dir.'/'.$baseName.'.'.$ext)) {
                return "images/products/{$baseName}.{$ext}";
            }
        }

        return null;
    }

    /**
     * Devuelve el nombre normalizado (slug) de un color para nombrar sus imágenes.
     */
    private static function colorSlug(string $name): string
    {
        return match ($name) {
            'Negro' => 'negro',
            'Blanco' => 'blanco',
            'Gris' => 'gris',
            'Rojo' => 'rojo',
            'Verde' => 'verde',
            'Azul' => 'azul',
            'Beige' => 'beige',
            'Bordeaux' => 'bordeaux',
            'Blanco/Negro' => 'blanco-negro',
            default => str()->slug($name),
        };
    }
}
