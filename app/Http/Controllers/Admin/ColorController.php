<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ColorController extends Controller
{
    /**
     * Lista de colores.
     */
    public function index(): View
    {
        return view('admin.colors.index', [
            'colors' => Color::withCount('products')->orderBy('name')->get(),
        ]);
    }

    /**
     * Crea un nuevo color.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'hex' => ['required', 'regex:/^#[0-9a-fA-F]{3,8}$/'],
        ]);

        Color::create($data);

        return back()->with('status', 'Color creado.');
    }

    /**
     * Actualiza un color.
     */
    public function update(Request $request, Color $color): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', Rule::unique('colors', 'name')->ignore($color)],
            'hex' => ['required', 'regex:/^#[0-9a-fA-F]{3,8}$/'],
        ]);

        $color->update($data);

        return back()->with('status', 'Color actualizado.');
    }

    /**
     * Elimina un color (quita la asignación de los productos).
     */
    public function destroy(Color $color): RedirectResponse
    {
        $color->delete();

        return back()->with('status', 'Color eliminado.');
    }
}
