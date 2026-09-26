<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Negro', 'hex' => '#111111'],
            ['name' => 'Blanco', 'hex' => '#f5f5f5'],
            ['name' => 'Gris', 'hex' => '#9ca3af'],
            ['name' => 'Rojo', 'hex' => '#dc2626'],
            ['name' => 'Verde', 'hex' => '#4d7c0f'],
            ['name' => 'Azul', 'hex' => '#2563eb'],
            ['name' => 'Beige', 'hex' => '#d6c3a6'],
            ['name' => 'Bordeaux', 'hex' => '#7f1d1d'],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(
                ['name' => $color['name']],
                ['hex' => $color['hex']],
            );
        }
    }
}
