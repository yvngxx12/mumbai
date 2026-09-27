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
                'name' => 'Urban Black',
                'type' => 'Básica',
                'price' => 18900,
                'colors' => ['Negro', 'Blanco'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'stock' => 40,
                'description' => 'Remera clásica negra de corte recto con estampado minimalista en el pecho. Algodón peinado 180 g/m².',
            ],
            [
                'name' => 'Street Basic',
                'type' => 'Básica',
                'price' => 15900,
                'colors' => ['Blanco', 'Negro', 'Gris'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'stock' => 55,
                'description' => 'La básica por excelencia. Corte regular, cuello reforzado y tela con caída perfecta para el día a día.',
            ],
            [
                'name' => 'Oversize Classic',
                'type' => 'Oversize',
                'price' => 23900,
                'colors' => ['Gris', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 32,
                'description' => 'Silueta oversize con hombros caídos y tiro largo. Pensada para un look relajado y con actitud.',
            ],
            [
                'name' => 'Downtown',
                'type' => 'Oversize',
                'price' => 24900,
                'colors' => ['Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 28,
                'description' => 'Inspirada en el centro de la ciudad. Hombros caídos, detalles de costura expuesta y estampa back print.',
            ],
            [
                'name' => 'Essential White',
                'type' => 'Básica',
                'price' => 14900,
                'colors' => ['Blanco', 'Gris'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'stock' => 60,
                'description' => 'Algodón puro, cuello cáncamo y corte limpio. La base de cualquier outfit urbano.',
            ],
            [
                'name' => 'Metro Nights',
                'type' => 'Oversize',
                'price' => 26900,
                'colors' => ['Negro', 'Bordeaux'],
                'sizes' => ['M', 'L', 'XL'],
                'stock' => 18,
                'description' => 'Oversize pesado para las noches de la ciudad. Tejido más grueso y caída estructurada.',
            ],
            [
                'name' => 'Concrete Tee',
                'type' => 'Básica',
                'price' => 16900,
                'colors' => ['Gris', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 44,
                'description' => 'Tonos cemento inspirados en el asfalto. Estampado de tacto suave y estilo street clásico.',
            ],
            [
                'name' => 'Rooftop Vibes',
                'type' => 'Oversize',
                'price' => 25900,
                'colors' => ['Blanco', 'Negro'],
                'sizes' => ['M', 'L', 'XL'],
                'stock' => 22,
                'description' => 'Para terrazas y techos de la ciudad. Fit holgado con estampa gráfica de gran formato.',
            ],
            [
                'name' => 'Alley Classic',
                'type' => 'Básica',
                'price' => 17400,
                'colors' => ['Rojo', 'Negro'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'stock' => 37,
                'description' => 'Clásica de colores intensos. Corte regular y tela fresca para usar todo el año.',
            ],
            [
                'name' => 'Block Letter',
                'type' => 'Oversize',
                'price' => 23400,
                'colors' => ['Negro', 'Blanco'],
                'sizes' => ['S', 'M', 'L'],
                'stock' => 26,
                'description' => 'Tipografía block en el pecho y diseño limpio. Algodón pesado 200 g/m² con terminación premium.',
            ],
            [
                'name' => 'Night Shift',
                'type' => 'Boxy',
                'price' => 18900,
                'colors' => ['Negro'],
                'sizes' => ['M', 'L', 'XL', 'XXL'],
                'stock' => 33,
                'description' => 'Corte boxy y derecho para uso diario. Negro profundo con serigrafía en el centro del pecho.',
            ],
            [
                'name' => 'Zero Chill',
                'type' => 'Básica',
                'price' => 15400,
                'colors' => ['Verde', 'Gris', 'Negro'],
                'sizes' => ['S', 'M', 'L'],
                'stock' => 41,
                'description' => 'Relajada y fresca. Verde oliva con estampa sutil a tono, ideal para looks monocromáticos.',
            ],
            [
                'name' => 'Streetline',
                'type' => 'Boxy',
                'price' => 21400,
                'colors' => ['Azul', 'Blanco'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 29,
                'description' => 'Líneas geométricas inspiradas en el skate. Corte boxy con mangas amplias y algodón orgánico.',
            ],
            [
                'name' => 'Canvas Co',
                'type' => 'Básica',
                'price' => 17900,
                'colors' => ['Beige', 'Blanco', 'Negro'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'stock' => 48,
                'description' => 'Tonos neutros sobre algodón suave. Una remera con carácter, pensada para superponer prendas.',
            ],
            [
                'name' => 'Empire Decade',
                'type' => 'Oversize',
                'price' => 24900,
                'colors' => ['Bordeaux', 'Negro'],
                'sizes' => ['M', 'L', 'XL'],
                'stock' => 20,
                'description' => 'Rememorando los 90. Oversize vintage con estampado desgastado y color burdeos profundo.',
            ],
            [
                'name' => 'Heavy Metal',
                'type' => 'Pesada',
                'price' => 20900,
                'colors' => ['Negro', 'Gris'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'stock' => 35,
                'description' => 'Tejido pesado 240 g/m² con estructura firme. Para quien busca una remera que aguante el paso del tiempo.',
            ],
            [
                'name' => 'Momentum',
                'type' => 'Boxy',
                'price' => 21400,
                'colors' => ['Verde', 'Negro'],
                'sizes' => ['S', 'M', 'L'],
                'stock' => 24,
                'description' => 'Corte urbano con volumen controlado. Costuras reforzadas y acabados limpios en cada detalle.',
            ],
            [
                'name' => 'Sundown Tee',
                'type' => 'Básica',
                'price' => 16400,
                'colors' => ['Blanco', 'Beige'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'stock' => 52,
                'description' => 'Tonos cálidos de atardecer. Corte relajado ideal para el verano, tela liviana y fresca.',
            ],
            [
                'name' => 'Nocturne',
                'type' => 'Oversize',
                'price' => 27900,
                'colors' => ['Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 15,
                'description' => 'La pieza premium de la colección. Negro total, fit oversize perfeccionado y etiqueta de edición limitada.',
            ],
            [
                'name' => 'Forma Urbana',
                'type' => 'Básica',
                'price' => 18900,
                'colors' => ['Rojo', 'Blanco', 'Negro'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 38,
                'description' => 'Formas básicas con impacto. Rojo vibrante y acabados prolijos para un look directo a la calle.',
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
                $image = self::photoFor($baseName)
                    ?? "images/products/{$baseName}.svg";
                $pivot[$color->id] = ['image' => $image];
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
            default => str()->slug($name),
        };
    }
}
