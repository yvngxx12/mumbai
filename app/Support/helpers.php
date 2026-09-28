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
     * Arma el link de WhatsApp con un mensaje precargado. Si no se pasa un
     * número, usa el primero configurado en shop.checkout.whatsapp.
     */
    function shop_whatsapp_link(string $message, ?string $number = null): string
    {
        $numbers = config('shop.checkout.whatsapp');

        if (is_array($numbers)) {
            $number ??= (string) array_key_first($numbers);
        } else {
            $number ??= (string) $numbers;
        }

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }
}

if (! function_exists('shop_whatsapp_numbers')) {
    /**
     * Devuelve los números de WhatsApp del checkout como [número => etiqueta].
     */
    function shop_whatsapp_numbers(): array
    {
        $numbers = config('shop.checkout.whatsapp');

        return is_array($numbers) ? $numbers : [$numbers => 'WhatsApp'];
    }
}
