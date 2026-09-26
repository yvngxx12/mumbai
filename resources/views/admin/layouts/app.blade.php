<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b0b0b">
    <title>@yield('title', 'Panel') — Admin {{ config('shop.brand') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <img src="{{ asset(config('shop.logo')) }}" alt="">
                <span>{{ config('shop.brand') }}</span>
            </a>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Panel</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">Productos</a>
                <a href="{{ route('admin.colors.index') }}" class="{{ request()->routeIs('admin.colors.*') ? 'is-active' : '' }}">Colores</a>
                <a href="{{ route('admin.sizes.index') }}" class="{{ request()->routeIs('admin.sizes.*') ? 'is-active' : '' }}">Talles</a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="link-muted">Ver tienda</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" style="width: 100%; justify-content: center;">Cerrar sesión</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            @if (session('status'))
                <div class="alert">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>