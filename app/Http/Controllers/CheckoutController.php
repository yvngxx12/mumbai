<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    /**
     * Muestra el formulario de confirmación con los datos de pago.
     */
    public function create(Request $request, Product $product): View|RedirectResponse
    {
        $color = (string) $request->query('color', '');
        $size = (string) $request->query('size', '');

        $hasColor = $product->colors->contains('name', $color);
        $hasSize = $product->sizes->contains('name', $size);

        if (! $hasColor || ! $hasSize) {
            return redirect()
                ->route('products.show', $product)
                ->with('checkout_error', 'Elegí un talle y un color válidos para continuar.');
        }

        return view('checkout.form', [
            'product' => $product,
            'color' => $color,
            'size' => $size,
            'deposit' => shop_deposit($product->price),
        ]);
    }

    /**
     * Registra la compra en estado pendiente hasta recibir el pago.
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'surname' => ['required', 'string', 'max:60'],
            'phone' => ['required', 'string', 'max:30'],
            'color' => ['required', Rule::in($product->colors->pluck('name')->all())],
            'size' => ['required', Rule::in($product->sizes->pluck('name')->all())],
        ]);

        $order = Order::create([
            'customer_name' => trim($data['name'].' '.$data['surname']),
            'customer_phone' => $data['phone'],
            'product_id' => $product->id,
            'product_name' => $product->name,
            'color_name' => $data['color'],
            'size_name' => $data['size'],
            'unit_price' => $product->price,
            'deposit' => shop_deposit($product->price),
            'status' => OrderStatus::Pending,
        ]);

        $order->generateOrderNumber();
        $order->save();

        return redirect()->route('checkout.confirmation', $order);
    }

    /**
     * Página de confirmación con el número de pedido y cómo enviar el comprobante.
     */
    public function confirmation(Order $order): View
    {
        return view('checkout.confirmation', ['order' => $order]);
    }
}
