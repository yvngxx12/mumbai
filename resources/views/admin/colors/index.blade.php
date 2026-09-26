@extends('admin.layouts.app')

@section('title', 'Colores')

@section('content')
    <header class="admin-header">
        <h1>Colores</h1>
    </header>

    <div class="panel">
        <div class="panel-head"><h2>Nuevo color</h2></div>
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.colors.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-field">
                        <label for="name">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Violeta" required>
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-field">
                        <label for="hex">Hex</label>
                        <input id="hex" type="text" name="hex" value="{{ old('hex', '#111111') }}" placeholder="#111111" required>
                        @error('hex') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Agregar color</button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head"><h2>Colores existentes</h2></div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Hex</th>
                        <th>Usos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colors as $color)
                        <tr>
                            <td><span class="swatch" style="--swatch: {{ $color->hex }}"></span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.colors.update', $color) }}" class="inline-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $color->name }}" required>
                            </td>
                            <td>
                                    <input type="text" name="hex" value="{{ $color->hex }}" required>
                            </td>
                            <td>{{ $color->products_count }}</td>
                            <td>
                                <div class="cell-actions">
                                    <button type="submit" class="btn btn-sm">Guardar</button>
                                </div>
                                </form>
                                <form method="POST" action="{{ route('admin.colors.destroy', $color) }}" onsubmit="return confirm('¿Eliminar este color? Se quitará de sus productos.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="margin-left: 8px;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection