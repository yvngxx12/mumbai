<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b0b0b">
    <title>Ingreso — {{ config('shop.brand') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="login-wrap">
        <div class="login-card">
            <div class="login-brand">
                <img src="{{ asset(config('shop.logo')) }}" alt="">
                <span>{{ config('shop.brand') }}</span>
                <small>Acceso administrador</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                    >
                </div>

                <div class="form-field">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Ingresar</button>
            </form>

            <a href="{{ route('home') }}" class="login-back">← Volver a la tienda</a>
        </div>
    </div>
</body>
</html>