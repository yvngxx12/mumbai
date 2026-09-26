<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['colors', 'sizes'])->orderBy('name')->get();

        return view('products.index', ['products' => $products]);
    }

    public function show(Product $product): View
    {
        $product->load(['colors', 'sizes', 'images']);

        return view('products.show', ['product' => $product]);
    }
}
