<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Lista de productos.
     */
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::with('colors')->latest()->paginate(15),
        ]);
    }

    /**
     * Formulario de alta de producto.
     */
    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product,
            'colors' => Color::orderBy('name')->get(),
            'sizes' => Size::orderBy('sort')->get(),
        ]);
    }

    /**
     * Persiste un producto nuevo.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $product = Product::create([
            'slug' => $this->uniqueSlug($data['name']),
            'name' => $data['name'],
            'type' => $data['type'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $this->storeImage($request->file('image')),
        ]);

        $this->syncColors($product, $request);
        $product->sizes()->sync($request->input('sizes', []));

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Producto creado correctamente.');
    }

    /**
     * Formulario de edición de producto.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product->load('colors', 'sizes'),
            'colors' => Color::orderBy('name')->get(),
            'sizes' => Size::orderBy('sort')->get(),
        ]);
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->boolean('remove_main_image')) {
            $this->deleteStoredFile($product->image);
            $product->image = null;
        } elseif ($image = $request->file('image')) {
            $this->deleteStoredFile($product->image);
            $product->image = $this->storeImage($image);
        }

        $product->fill([
            'slug' => $this->uniqueSlug($data['name'], $product->id),
            'name' => $data['name'],
            'type' => $data['type'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
        ])->save();

        $this->syncColors($product, $request);
        $product->sizes()->sync($request->input('sizes', []));

        return back()->with('status', 'Producto actualizado.');
    }

    /**
     * Elimina un producto y sus imágenes.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteStoredFile($product->image);

        foreach ($product->colors as $color) {
            $this->deleteStoredFile($color->pivot->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto eliminado.');
    }

    /**
     * Valida y devuelve los datos comunes de alta/edición.
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif', 'max:4096'],
            'colors' => ['array'],
            'colors.*' => ['integer', 'exists:colors,id'],
            'sizes' => ['array'],
            'sizes.*' => ['integer', 'exists:sizes,id'],
        ]);
    }

    /**
     * Asocia colores con su imagen correspondiente en la tabla pivote.
     */
    private function syncColors(Product $product, Request $request): void
    {
        $colorIds = $request->input('colors', []);
        $uploads = $request->file('color_images') ?? [];
        $remove = $request->input('remove_color_images') ?? [];
        $pivot = [];

        foreach ($colorIds as $colorId) {
            $existing = $product->colors()
                ->where('colors.id', $colorId)
                ->first()?->pivot?->image;

            $file = $uploads[$colorId] ?? null;

            if (in_array($colorId, $remove, true)) {
                if ($existing !== null) {
                    $this->deleteStoredFile($existing);
                }

                $pivot[$colorId] = ['image' => null];

                continue;
            }

            if ($file instanceof UploadedFile) {
                if ($existing !== null) {
                    $this->deleteStoredFile($existing);
                }

                $pivot[$colorId] = ['image' => $this->storeImage($file)];

                continue;
            }

            $pivot[$colorId] = ['image' => $existing];
        }

        $product->colors()->sync($pivot);
    }

    /**
     * Guarda una imagen subida y devuelve su ruta pública.
     */
    private function storeImage(?UploadedFile $file): ?string
    {
        if ($file === null) {
            return null;
        }

        $name = Str::random(24).'.'.$file->getClientOriginalExtension();

        return 'images/'.$file->storeAs('products', $name, 'uploads');
    }

    /**
     * Elimina del disco la imagen referenciada por una ruta pública.
     */
    private function deleteStoredFile(?string $path): void
    {
        if ($path === null) {
            return;
        }

        $relative = Str::after($path, 'images/');

        if ($relative === $path) {
            return;
        }

        Storage::disk('uploads')->delete($relative);
    }

    /**
     * Genera un slug único a partir del nombre.
     */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'producto';
        $slug = $base;
        $counter = 2;

        while (Product::query()
            ->where('slug', $slug)
            ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
