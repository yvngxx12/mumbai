<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Lista de compras con filtro por estado.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', '');

        $query = Order::query()->with('product');

        if (OrderStatus::tryFrom((string) $status)) {
            $query->where('status', $status);
        }

        return view('admin.orders.index', [
            'orders' => $query->latest()->paginate(20),
            'currentStatus' => $status,
            'counts' => [
                'pending' => Order::where('status', OrderStatus::Pending)->count(),
                'confirmed' => Order::where('status', OrderStatus::Confirmed)->count(),
                'cancelled' => Order::where('status', OrderStatus::Cancelled)->count(),
            ],
        ]);
    }

    /**
     * Confirma una compra pendiente (pago acreditado).
     */
    public function accept(Order $order): RedirectResponse
    {
        if ($order->status === OrderStatus::Pending) {
            $order->update(['status' => OrderStatus::Confirmed]);
        }

        return back()->with('status', 'Pedido '.$order->order_number.' confirmado.');
    }

    /**
     * Cancela una compra pendiente o confirmada.
     */
    public function cancel(Order $order): RedirectResponse
    {
        if ($order->status !== OrderStatus::Cancelled) {
            $order->update(['status' => OrderStatus::Cancelled]);
        }

        return back()->with('status', 'Pedido '.$order->order_number.' cancelado.');
    }
}
