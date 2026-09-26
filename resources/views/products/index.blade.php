@extends('layouts.app')

@section('title', 'Remeras')

@section('content')
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">FIRST DROP</h1>
            <p class="hero-subtitle">¡Reserva tu remera antes de que se acaben!</p>
            <a href="#catalogo" class="hero-cta">Ver colección</a>
        </div>
    </section>

    <section id="catalogo" class="catalog">
        <div class="container">
            <header class="section-head">
                <h2 class="section-title">Colección</h2>
                <p class="section-count">{{ $products->count() }} productos</p>
            </header>

            <div class="catalog-grid">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="product-card" style="--i: {{ $loop->index }}">
                        <div class="product-card-media">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                        </div>
                        <div class="product-card-body">
                            <h3 class="product-card-name">{{ $product->name }}</h3>
                            <p class="product-card-type">{{ $product->type }}</p>
                            <div class="product-card-bottom">
                                <span class="product-card-price">{{ shop_price($product->price) }}</span>
                                <span class="product-card-colors">
                                    @foreach ($product->colors as $color)
                                        <i class="color-dot" style="--swatch: {{ $color->hex }}"></i>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection