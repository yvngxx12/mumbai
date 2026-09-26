<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'price',
        'image',
        'stock',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'float',
        ];
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class)->withPivot('image');
    }

    /**
     * Imagen que corresponde a un color de este producto
     * (cae en la imagen principal si el color no tiene la propia).
     */
    public function imageForColor(Color $color): string
    {
        $pivot = $this->colors->firstWhere('id', $color->id);

        return $pivot?->pivot->image ?? $this->image;
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }
}
