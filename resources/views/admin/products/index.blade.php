@extends('admin.layouts.app')

@section('title', 'Productos')

@section('content')
    <header class="admin-header">
        <h1>Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Nuevo producto</a>
    </header>

    <div class="panel">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Colores</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                @if ($product->image)
                                    <img class="thumb" src="{{ asset($product->image) }}" alt="">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->type }}</td>
                            <td>{{ shop_price($product->price) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    @foreach ($product->colors as $color)
                                        <span class="swatch" style="--swatch: {{ $color->hex }}" title="{{ $color->name }}"></span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="cell-actions">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('¿Eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="color: var(--text-muted); text-align: center; padding: 32px;">
                                Aún no hay productos. Creá el primero.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($products->hasPages())
                <div style="display: flex; align-items: center; gap: 10px; margin-top: 22px;">
                    <a href="{{ $products->previousPageUrl() ?? '#' }}" class="btn btn-sm {{ $products->onFirstPage() ? 'disabled' : '' }}" style="{{ $products->onFirstPage() ? 'opacity: .4; pointer-events: none;' : '' }}">← Anterior</a>
                    <span style="color: var(--text-muted); font-size: 0.85rem;">Página {{ $products->currentPage() }} de {{ $products->lastPage() }}</span>
                    <a href="{{ $products->nextPageUrl() ?? '#' }}" class="btn btn-sm {{ $products->hasMorePages() ? '' : 'disabled' }}" style="{{ $products->hasMorePages() ? '' : 'opacity: .4; pointer-events: none;' }}">Siguiente →</a>
                </div>
            @endif
        </div>
    </div>
@endsection