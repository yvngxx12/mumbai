@extends('admin.layouts.app')

@section('title', $product->exists ? 'Editar '.$product->name : 'Nuevo producto')

@section('content')
    <header class="admin-header">
        <h1>{{ $product->exists ? 'Editar producto' : 'Nuevo producto' }}</h1>
        <a href="{{ route('admin.products.index') }}" class="link-muted">← Volver al listado</a>
    </header>

    <form
        method="POST"
        action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="panel">
            <div class="panel-head"><h2>Información</h2></div>
            <div class="panel-body">
                <div class="form-grid">
                    <div class="form-field">
                        <label for="name">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-field">
                        <label for="type">Tipo</label>
                        <input id="type" type="text" name="type" value="{{ old('type', $product->type ?? 'Básica') }}" required>
                        @error('type') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-field">
                        <label for="price">Precio ({{ config('shop.currency') }})</label>
                        <input id="price" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                        @error('price') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-field">
                        <label for="stock">Stock</label>
                        <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
                        @error('stock') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-field span-2">
                        <label for="description">Descripción</label>
                        <textarea id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><h2>Imagen de portada</h2></div>
            <div class="panel-body">
                @if ($product->exists && $product->image)
                    <div style="margin-bottom: 16px;">
                        <img src="{{ asset($product->image) }}" alt="" style="width: 140px; border: 1px solid var(--border); border-radius: var(--radius);">
                    </div>
                    <label style="display: flex; align-items: center; gap: 8px; text-transform: none; letter-spacing: 0;">
                        <input type="checkbox" name="remove_main_image" value="1" style="width: auto;">
                        Quitar imagen actual
                    </label>
                @endif

                <label for="image" style="margin-top: 12px;">Reemplazar o definir imagen</label>
                <input id="image" type="file" name="image" accept="image/*">
                @error('image') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><h2>Colores e imágenes</h2></div>
            <div class="panel-body">
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 18px;">
                    Cada color puede llevar su propia imagen (la grande cambia al seleccionarlo). Si no se sube imagen, el producto usa la de portada.
                </p>

                @php
                    $selectedColorIds = old('colors', $product->colors->pluck('id')->all());
                @endphp

                @foreach ($colors as $color)
                    <div class="color-option">
                        <input
                            type="checkbox"
                            name="colors[]"
                            id="color-{{ $color->id }}"
                            value="{{ $color->id }}"
                            data-color-checkbox
                            {{ in_array($color->id, $selectedColorIds) ? 'checked' : '' }}
                        >
                        <span class="swatch" style="--swatch: {{ $color->hex }}"></span>

                        <div class="color-meta">
                            <label for="color-{{ $color->id }}">{{ $color->name }}</label>
                            <div class="small">Hex: {{ $color->hex }}</div>

                            <div class="color-image-box" data-color-image-box>
                                @php
                                    $pivotImage = $product->colors->firstWhere('id', $color->id)?->pivot?->image;
                                @endphp

                                @if ($product->exists && $pivotImage)
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                        <img src="{{ asset($pivotImage) }}" alt="" style="width: 56px; border: 1px solid var(--border); border-radius: var(--radius);">
                                        <label style="display: flex; align-items: center; gap: 6px; text-transform: none; letter-spacing: 0; margin: 0;">
                                            <input type="checkbox" name="remove_color_images[]" value="{{ $color->id }}" style="width: auto;">
                                            Quitar imagen
                                        </label>
                                    </div>
                                @endif

                                <input type="file" name="color_images[{{ $color->id }}]" accept="image/*" {{ in_array($color->id, $selectedColorIds) ? '' : 'disabled' }}>
                            </div>
                        </div>
                    </div>
                @endforeach

                @error('colors') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><h2>Talles</h2></div>
            <div class="panel-body">
                @php
                    $selectedSizeIds = old('sizes', $product->sizes->pluck('id')->all());
                @endphp

                <div>
                    @foreach ($sizes as $size)
                        <label class="size-option">
                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}" {{ in_array($size->id, $selectedSizeIds) ? 'checked' : '' }}>
                            {{ $size->name }}
                        </label>
                    @endforeach
                </div>

                @error('sizes') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                {{ $product->exists ? 'Guardar cambios' : 'Crear producto' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn">Cancelar</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-color-checkbox]').forEach(function (checkbox) {
                var render = function () {
                    var box = checkbox.closest('.color-option').querySelector('[data-color-image-box]');
                    if (!box) return;
                    box.style.opacity = checkbox.checked ? '1' : '0.35';
                    box.querySelectorAll('input').forEach(function (input) {
                        input.disabled = !checkbox.checked;
                    });
                };
                checkbox.addEventListener('change', render);
                render();
            });
        });
    </script>
@endsection