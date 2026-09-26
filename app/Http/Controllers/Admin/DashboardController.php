<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'products' => Product::withCount('colors', 'sizes')->latest()->limit(8)->get(),
            'productCount' => Product::count(),
            'colorCount' => Color::count(),
            'sizeCount' => Size::count(),
        ]);
    }
}
