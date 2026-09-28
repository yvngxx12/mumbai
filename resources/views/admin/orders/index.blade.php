@extends('admin.layouts.app')

@section('title', 'Compras')

@section('content')
    <header class="admin-header">
        <h1>Compras</h1>
        <div class="admin-tabs">
            <a href="{{ route('admin.orders.index') }}" class="{{ $currentStatus === '' ? 'is-active' : '' }}">Todas</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="{{ $currentStatus === 'pending' ? 'is-active' : '' }}">Pendientes ({{ $counts['pending'] }})</a>
            <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="{{ $currentStatus === 'confirmed' ? 'is-active' : '' }}">Confirmadas ({{ $counts['confirmed'] }})</a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="{{ $currentStatus === 'cancelled' ? 'is-active' : '' }}">Canceladas ({{ $counts['cancelled'] }})</a>
        </div>
    </header>

    <div class="panel">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Prenda</th>
                        <th>Total</th>
                        <th>Seña (50%)</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                                <div class="table-sub">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td>
                                {{ $order->customer_name }}
                                <div class="table-sub">{{ $order->customer_phone }}</div>
                            </td>
                            <td>
                                {{ $order->product_name }}
                                <div class="table-sub">{{ $order->color_name }} · talle {{ $order->size_name }}</div>
                            </td>
                            <td>{{ shop_price($order->unit_price) }}</td>
                            <td>{{ shop_price($order->deposit) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status->value }}">{{ $order->status->label() }}</span>
                            </td>
                            <td>
                                @if ($order->status->value === 'pending')
                                    <div class="cell-actions">
                                        <form method="POST" action="{{ route('admin.orders.accept', $order) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Aceptar</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}" onsubmit="return confirm('¿Cancelar el pedido {{ $order->order_number }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                        </form>
                                    </div>
                                @elseif ($order->status->value === 'confirmed')
                                    <div class="cell-actions">
                                        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}" onsubmit="return confirm('¿Cancelar el pedido {{ $order->order_number }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="color: var(--text-muted); text-align: center; padding: 32px;">
                                {{ $currentStatus ? 'No hay compras en este estado.' : 'Todavía no hay compras.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($orders->hasPages())
                <div style="display: flex; align-items: center; gap: 10px; margin-top: 22px;">
                    <a href="{{ $orders->previousPageUrl() ?? '#' }}" class="btn btn-sm {{ $orders->onFirstPage() ? 'disabled' : '' }}" style="{{ $orders->onFirstPage() ? 'opacity: .4; pointer-events: none;' : '' }}">← Anterior</a>
                    <span style="color: var(--text-muted); font-size: 0.85rem;">Página {{ $orders->currentPage() }} de {{ $orders->lastPage() }}</span>
                    <a href="{{ $orders->nextPageUrl() ?? '#' }}" class="btn btn-sm {{ $orders->hasMorePages() ? '' : 'disabled' }}" style="{{ $orders->hasMorePages() ? '' : 'opacity: .4; pointer-events: none;' }}">Siguiente →</a>
                </div>
            @endif
        </div>
    </div>
@endsection