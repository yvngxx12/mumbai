<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', config('shop.tagline'))">
    <meta name="theme-color" content="#0b0b0b">
    <title>@yield('title', 'Remeras') — {{ config('shop.brand') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset(config('shop.logo')) }}" alt="{{ config('shop.brand') }} logo" class="brand-logo">
                <span class="brand-name">{{ config('shop.brand') }}</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Inicio</a>
                <a href="{{ route('home') }}#catalogo">Colección</a>
                {{-- Espacio preparado para sumar más opciones al menú --}}
            </nav>
        </div>
    </header>

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <p class="footer-brand">{{ config('shop.brand') }}</p>
            <p class="footer-note">&copy; {{ date('Y') }} {{ config('shop.brand') }} · Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>