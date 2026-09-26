<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SizeController extends Controller
{
    /**
     * Lista de talles.
     */
    public function index(): View
    {
        return view('admin.sizes.index', [
            'sizes' => Size::withCount('products')->orderBy('sort')->get(),
        ]);
    }

    /**
     * Crea un nuevo talle.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'sort' => ['required', 'integer', 'min:0'],
        ]);

        Size::create($data);

        return back()->with('status', 'Talle creado.');
    }

    /**
     * Actualiza un talle.
     */
    public function update(Request $request, Size $size): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20', Rule::unique('sizes', 'name')->ignore($size)],
            'sort' => ['required', 'integer', 'min:0'],
        ]);

        $size->update($data);

        return back()->with('status', 'Talle actualizado.');
    }

    /**
     * Elimina un talle (quita la asignación de los productos).
     */
    public function destroy(Size $size): RedirectResponse
    {
        $size->delete();

        return back()->with('status', 'Talle eliminado.');
    }
}
