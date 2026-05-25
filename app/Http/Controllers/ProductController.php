<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        if ($request->filled('categoria')) {
            $category = Category::where('slug', $request->categoria)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        if ($request->filled('busca')) {
            $search = $request->busca;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('preco_min')) {
            $query->where('price', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('price', '<=', $request->preco_max);
        }

        $sort = $request->get('ordenar', 'latest');
        match($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::where('active', true)->orderBy('order')->get();
        $currentCategory = $request->filled('categoria')
            ? Category::where('slug', $request->categoria)->first()
            : null;

        return view('products.index', compact('products', 'categories', 'currentCategory'));
    }

    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
