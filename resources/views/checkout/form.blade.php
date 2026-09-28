@extends('layouts.app')

@section('title', 'Confirmar compra')

@section('content')
    @php
        $dropDate = config('shop.checkout.drop_date');
        $total = shop_price($product->price);
        $depositLabel = shop_price($deposit);
        $restLabel = shop_price($product->price - $deposit);
    @endphp

    <main class="site-main">
        <section class="checkout">
            <div class="container checkout-wrap">
                <header class="checkout-head">
                    <p class="checkout-eyebrow">Preventa</p>
                    <h1 class="checkout-title">Confirmá tu compra</h1>
                </header>

                <form method="POST" action="{{ route('checkout.store', $product) }}" class="checkout-grid">
                    @csrf
                    <input type="hidden" name="color" value="{{ $color }}">
                    <input type="hidden" name="size" value="{{ $size }}">

                    <div class="checkout-col">
                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Tus datos</h2>

                            @if ($errors->any())
                                <div class="alert-error">
                                    Completá los datos marcados para continuar.
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label" for="name">Nombre</label>
                                    <input
                                        class="form-input @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name') }}"
                                        placeholder="Tu nombre"
                                        required
                                        autocomplete="given-name"
                                    >
                                </div>

                                <div class="form-field">
                                    <label class="form-label" for="surname">Apellido</label>
                                    <input
                                        class="form-input @error('surname') is-invalid @enderror"
                                        id="surname"
                                        name="surname"
                                        type="text"
                                        value="{{ old('surname') }}"
                                        placeholder="Tu apellido"
                                        required
                                        autocomplete="family-name"
                                    >
                                </div>
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="phone">Número de teléfono</label>
                                <input
                                    class="form-input @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    placeholder="11 2345 6789"
                                    required
                                    autocomplete="tel"
                                >
                                <p class="form-hint">Lo usamos para coordinar la entrega y enviarte novedades.</p>
                            </div>
                        </div>

                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Cómo funciona</h2>
                            <ol class="step-list">
                                <li>
                                    <strong>Fecha de entrega.</strong>
                                    El drop sale el {{ $dropDate }} y empezamos a entregar ese día por orden de compra.
                                </li>
                                <li>
                                    <strong>Reserva con el 50%.</strong>
                                    Transferís la seña de <strong>{{ $depositLabel }}</strong> para reservar tu prenda.
                                </li>
                                <li>
                                    <strong>Al recibirla.</strong>
                                    Abonás el {{ $restLabel }} restante al momento de la entrega.
                                </li>
                                <li>
                                    <strong>Pago de la seña.</strong>
                                    Al confirmar, tu pedido queda en <strong>pendiente</strong> hasta que acreditemos la transferencia.
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="checkout-col">
                        <div class="checkout-card checkout-summary">
                            <h2 class="checkout-card-title">Tu pedido</h2>
                            <dl class="summary-list">
                                <div class="summary-row">
                                    <dt>Prenda</dt>
                                    <dd>{{ $product->name }}</dd>
                                </div>
                                <div class="summary-row">
                                    <dt>Color</dt>
                                    <dd>
                                        <span class="summary-swatch" style="--swatch: {{ $product->colors->firstWhere('name', $color)?->hex ?? '#eee' }}"></span>
                                        {{ $color }}
                                    </dd>
                                </div>
                                <div class="summary-row">
                                    <dt>Talle</dt>
                                    <dd>{{ $size }}</dd>
                                </div>
                                <div class="summary-row">
                                    <dt>Precio</dt>
                                    <dd>{{ $total }}</dd>
                                </div>
                                <div class="summary-row summary-total">
                                    <dt>Seña a abonar (50%)</dt>
                                    <dd>{{ $depositLabel }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Transferí la seña a</h2>
                            <div class="bank-box">
                                <div class="bank-row">
                                    <span class="bank-label">CVU</span>
                                    <span class="bank-value">{{ config('shop.checkout.cvu') }}</span>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-label">Alias</span>
                                    <span class="bank-value">{{ config('shop.checkout.alias') }}</span>
                                </div>
                            </div>
                            <p class="checkout-note">
                                Enviás {{ $depositLabel }} por transferencia y nos mandás el comprobante.
                            </p>

                            <a
                                class="wa-btn"
                                target="_blank"
                                rel="noopener"
                                href="{{ shop_whatsapp_link('Hola ' . config('shop.brand') . '! Quiero confirmar los datos para enviar el comprobante de mi preventa.') }}"
                            >
                                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2Zm5 14c-.3.8-1.6 1.5-2.3 1.6-.6.1-1.3.1-2.1-.1a7 7 0 0 1-1.9-1.2c-3.3-2.9-4.3-5.8-4.4-6.1-.1-.2-.8-2 .4-3.8.7-1 1.6-1.2 1.9-1.1.4.1.8.3 1 .9l.9 2.1c.2.4.3.7.1 1a1.2 1.2 0 0 1-.5.6l-.7.7c-.3.3-.5.6-.2 1 .3.5 1.4 2.3 3 3.6 2.1 1.7 3.1 1.9 3.6 2 .4.1.9 0 1.2-.5.4-.5 1.4-1.7 1.7-2.3.3-.5.6-.5 1.1-.4.5.2 3.2 1.5 3.7 1.8.5.3.9.5 1 .8Z"/>
                                </svg>
                                Consultar por WhatsApp
                            </a>
                        </div>

                        <button type="submit" class="btn-confirm">Confirmar compra</button>
                        <p class="checkout-fineprint">
                            Al confirmar, tu pedido queda en estado <strong>pendiente</strong> hasta acreditar el pago del 50%.
                        </p>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection