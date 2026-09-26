@extends('admin.layouts.app')

@section('title', 'Panel')

@section('content')
    <header class="admin-header">
        <h1>Panel</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Nuevo producto</a>
    </header>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $productCount }}</div>
            <div class="stat-label">Productos</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $colorCount }}</div>
            <div class="stat-label">Colores</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $sizeCount }}</div>
            <div class="stat-label">Talles</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <h2>Últimos productos</h2>
            <a href="{{ route('admin.products.index') }}" class="link-muted">Ver todos</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
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
                                <div class="cell-actions">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm">Editar</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection