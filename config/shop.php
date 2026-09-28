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

    /*
    | Datos del checkout (preventa contra transferencia).
    | CVU / Alias / WhatsApp se setean en Render Environment con las claves
    | SHOP_CVU, SHOP_ALIAS y SHOP_WHATSAPP, o directamente acá.
    */
    'checkout' => [
        'deposit_percent' => 50,
        'cvu' => env('SHOP_CVU', '0000000000000000000000'),
        'alias' => env('SHOP_ALIAS', 'mumbai.pagos'),
        'whatsapp' => env('SHOP_WHATSAPP', '5491100000000'),
        'drop_date' => env('SHOP_DROP_DATE', '25 de octubre de 2026'),
    ],
];
