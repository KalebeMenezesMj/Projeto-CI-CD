<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('active', true)
            ->orderBy('order')
            ->withCount(['activeProducts'])
            ->get();

        $newProducts = Product::active()
            ->with('category')
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'newProducts'));
    }
}
