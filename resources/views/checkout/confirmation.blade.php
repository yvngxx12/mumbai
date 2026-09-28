@extends('layouts.app')

@section('title', 'Pedido '.$order->order_number)

@section('content')
    @php
        $depositLabel = shop_price($order->deposit);
        $dropDate = config('shop.checkout.drop_date');
        $whatsappText = sprintf(
            'Hola %s! Te envío el comprobante de la transferencia de %s del pedido %s (%s · %s · talle %s).',
            config('shop.brand'),
            $depositLabel,
            $order->order_number,
            $order->product_name,
            $order->color_name,
            $order->size_name
        );
    @endphp

    <main class="site-main">
        <section class="checkout">
            <div class="container checkout-wrap">
                <header class="checkout-head">
                    <p class="checkout-eyebrow">Pedido registrado</p>
                    <h1 class="checkout-title">{{ $order->order_number }}</h1>
                    <p class="checkout-subtitle">
                        Tu compra quedó en <strong>pendiente</strong> hasta que acreditemos la seña.
                    </p>
                </header>

                <div class="checkout-confirm-grid">
                    <div class="checkout-card">
                        <h2 class="checkout-card-title">Qué tenés que hacer ahora</h2>
                        <ol class="step-list">
                            <li>
                                <strong>Transferí la seña de {{ $depositLabel }}</strong>
                                a la cuenta que figura abajo.
                            </li>
                            <li>
                                <strong>Enviá el comprobante por WhatsApp</strong>
                                tocando el botón verde.
                            </li>
                            <li>
                                Cuando acreditemos el pago, te confirmamos la compra.
                            </li>
                            <li>
                                Empezamos a entregar el {{ $dropDate }} por orden de compra.
                            </li>
                        </ol>
                    </div>

                    <div class="checkout-card">
                        <h2 class="checkout-card-title">Datos para la transferencia</h2>
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

                        <div class="wa-btns">
                            @foreach (shop_whatsapp_numbers() as $waNumber => $waLabel)
                                <a
                                    class="wa-btn"
                                    target="_blank"
                                    rel="noopener"
                                    href="{{ shop_whatsapp_link($whatsappText, $waNumber) }}"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2Zm5 14c-.3.8-1.6 1.5-2.3 1.6-.6.1-1.3.1-2.1-.1a7 7 0 0 1-1.9-1.2c-3.3-2.9-4.3-5.8-4.4-6.1-.1-.2-.8-2 .4-3.8.7-1 1.6-1.2 1.9-1.1.4.1.8.3 1 .9l.9 2.1c.2.4.3.7.1 1a1.2 1.2 0 0 1-.5.6l-.7.7c-.3.3-.5.6-.2 1 .3.5 1.4 2.3 3 3.6 2.1 1.7 3.1 1.9 3.6 2 .4.1.9 0 1.2-.5.4-.5 1.4-1.7 1.7-2.3.3-.5.6-.5 1.1-.4.5.2 3.2 1.5 3.7 1.8.5.3.9.5 1 .8Z"/>
                                    </svg>
                                    Enviar comprobante por WhatsApp · {{ $waLabel }}
                                </a>
                            @endforeach
                        </div>

                        <p class="checkout-note">
                            Resumen: {{ $order->product_name }} · {{ $order->color_name }} · talle {{ $order->size_name }} ·
                            seña {{ $depositLabel }} del total de {{ shop_price($order->unit_price) }}.
                        </p>
                    </div>
                </div>

                <p class="checkout-back">
                    <a href="{{ route('home') }}">← Volver a la tienda</a>
                </p>
            </div>
        </section>
    </main>
@endsection