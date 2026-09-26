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
