@extends('admin.layouts.app')

@section('title', 'Talles')

@section('content')
    <header class="admin-header">
        <h1>Talles</h1>
    </header>

    <div class="panel">
        <div class="panel-head"><h2>Nuevo talle</h2></div>
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.sizes.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-field">
                        <label for="name">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ej: XXXL" required>
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-field">
                        <label for="sort">Orden</label>
                        <input id="sort" type="number" min="0" name="sort" value="{{ old('sort', 0) }}" required>
                        @error('sort') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Agregar talle</button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head"><h2>Talles existentes</h2></div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Orden</th>
                        <th>Usos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sizes as $size)
                        <tr>
                            <td>
                                <form method="POST" action="{{ route('admin.sizes.update', $size) }}" class="inline-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $size->name }}" required>
                            </td>
                            <td>
                                    <input type="number" name="sort" min="0" value="{{ $size->sort }}" style="width: 90px;" required>
                            </td>
                            <td>{{ $size->products_count }}</td>
                            <td>
                                <div class="cell-actions">
                                    <button type="submit" class="btn btn-sm">Guardar</button>
                                </div>
                                </form>
                                <form method="POST" action="{{ route('admin.sizes.destroy', $size) }}" onsubmit="return confirm('¿Eliminar este talle? Se quitará de sus productos.');">
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