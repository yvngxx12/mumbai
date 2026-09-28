<?php

if (! function_exists('shop_price')) {
    /**
     * Formatea un precio con la moneda configurada en config/shop.php.
     */
    function shop_price(float $amount): string
    {
        $formatted = number_format($amount, 2, ',', '.');

        return config('shop.currency').' '.$formatted;
    }
}

if (! function_exists('shop_deposit')) {
    /**
     * Devuelve la seña a abonar para reservar una prenda: el porcentaje
     * configurado (por defecto 50%) del precio completo.
     */
    function shop_deposit(float $amount): float
    {
        $percent = (int) config('shop.checkout.deposit_percent', 50);

        return round($amount * $percent / 100, 2);
    }
}

if (! function_exists('shop_whatsapp_link')) {
    /**
     * Arma el link de WhatsApp con un mensaje precargado.
     */
    function shop_whatsapp_link(string $message): string
    {
        return 'https://wa.me/'.config('shop.checkout.whatsapp').'?text='.rawurlencode($message);
    }
}
