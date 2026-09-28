<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'product_id',
        'product_name',
        'color_name',
        'size_name',
        'unit_price',
        'deposit',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit_price' => 'float',
            'deposit' => 'float',
            'status' => OrderStatus::class,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Número humano de pedido, p.ej. MUMBAI-0007, derivado del id.
     */
    public function generateOrderNumber(): void
    {
        $this->order_number = config('shop.brand').'-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }
}
