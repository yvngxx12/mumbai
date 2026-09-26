<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ajustes de la tienda
    |--------------------------------------------------------------------------
    |
    | Toda la configuración visible de la tienda (nombre de la marca, eslogan,
    | moneda y logo) está centralizada acá para poder cambiarla en un solo
    | lugar sin tocar el resto del código.
    |
    */

    'brand' => env('SHOP_BRAND', 'Mumbai'),

    'tagline' => env('SHOP_TAGLINE', 'Streetwear urbano · Algodón premium'),

    'currency' => env('SHOP_CURRENCY', 'AR$'),

    /*
    | Ruta del logo dentro de public/. Reemplazá el archivo en esa carpeta
    | sobreescribiéndolo, o cambiá la ruta acá, para actualizar el logo sin
    | modificar las vistas.
    */
    'logo' => 'images/logo.png',
];
