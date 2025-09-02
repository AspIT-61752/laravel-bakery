<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $products = Product::with(['productType', 'ingredients'])->get();
        return view('post.index', [
            'posts' => $products
        ]);
    }

    public function recipe($slug)
    {
        // Fetch product by slug, and add the type and ingredients
        $product = Product::with(['productType', 'ingredients'])->where('slug', $slug)->firstOrFail(); // There's only one
        return view('post.recipe', [
            'post' => $product // Pass the product to the view
        ]);
    }
}
