@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @php
        $colors = $product->colors;
        $colorViews = $colors
            ->map(fn ($color) => [
                'name' => $color->name,
                'hex' => $color->hex,
                'image' => $product->imageForColor($color),
                'back' => $product->backImageForColor($color),
            ])
            ->values();
        $thumbImages = $colorViews->unique('image')->values();
        $primaryImage = $thumbImages->first()['image'] ?? $product->image;
        $hasBackViews = $colorViews->contains(fn ($view) => $view['back'] !== null);
    @endphp

    <section class="product-detail" data-product-root>
        <div class="container product-detail-grid">
            <div class="product-gallery">
                <div class="product-gallery-main">
                    <img
                        src="{{ asset($primaryImage) }}"
                        alt="{{ $product->name }}"
                        class="gallery-image"
                        data-gallery-main
                    >
                </div>

                @if ($hasBackViews)
                    <button type="button" class="view-back" data-view-back hidden>
                        <span data-view-back-label>Ver parte trasera</span>
                    </button>
                @endif

                @if ($thumbImages->count() > 1)
                    <div class="product-gallery-thumbs">
                        @foreach ($thumbImages as $colorImage)
                            <button
                                type="button"
                                class="gallery-thumb {{ $loop->first ? 'is-active' : '' }}"
                                data-thumb-color="{{ $colorImage['name'] }}"
                                data-thumb-image="{{ asset($colorImage['image']) }}"
                                aria-label="Color {{ $colorImage['name'] }}"
                            >
                                <img src="{{ asset($colorImage['image']) }}" alt="">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="product-info">
                <span class="product-type">{{ $product->type }}</span>
                <h1 class="product-name">{{ $product->name }}</h1>
                <p class="product-price">{{ shop_price($product->price) }}</p>

                <div class="product-section">
                    <h2 class="product-section-title">Talle</h2>
                    <div class="size-selector" data-size-selector>
                        @foreach ($product->sizes as $size)
                            <button
                                type="button"
                                class="size-btn {{ $loop->first ? 'is-selected' : '' }}"
                                value="{{ $size->name }}"
                            >{{ $size->name }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="product-section">
                    <h2 class="product-section-title">Color</h2>
                    <div class="color-selector" data-color-selector>
                        @foreach ($colorViews as $colorView)
                            <button
                                type="button"
                                class="color-btn {{ $loop->first ? 'is-selected' : '' }}"
                                style="--swatch: {{ $colorView['hex'] }}"
                                value="{{ $colorView['name'] }}"
                                title="{{ $colorView['name'] }}"
                                aria-label="Color {{ $colorView['name'] }}"
                                data-color-name="{{ $colorView['name'] }}"
                                data-color-image="{{ asset($colorView['image']) }}"
                                data-color-back="{{ $colorView['back'] ? asset($colorView['back']) : '' }}"
                            ></button>
                        @endforeach
                    </div>
                    <p class="selected-color" data-selected-color>
                        {{ $colors->isNotEmpty() ? $colors->first()->name : '' }}
                    </p>
                </div>

                <p class="product-description">{{ $product->description }}</p>

                <button type="button" class="btn-buy" data-buy-button>Comprar</button>
                <p class="buy-message" data-buy-message hidden>
                    El sistema de pagos estará disponible próximamente.
                </p>
            </div>
        </div>
    </section>
@endsection