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
        // Fetch product by slug, and add the type, ingredients, comments, and comment users
        $product = Product::with(['productType', 'ingredients', 'comments.user'])->where('slug', $slug)->firstOrFail();
        return view('post.recipe', [
            'post' => $product // Pass the product to the view
        ]);
        // https://laravel.com/docs/12.x/eloquent-relationships
        // The ORM uses the relationships defined in the models to fetch related data
        // It talks about "Eloquent eager loading" in the docs, but I'm not sure what it means
        // I wonder if Laravel uses eager loading when it's just with()
        // "Dynamic relationship properties perform "lazy loading", meaning they will only load their relationship data when you actually access them. Because of this, developers often use eager loading to pre-load relationships they know will be accessed after loading the model. Eager loading provides a significant reduction in SQL queries that must be executed to load a model's relations."
        // https://laravel.com/docs/12.x/eloquent-relationships#eager-loading
        // I'm not sure if they use lazy loading or eager loading when using with(), it should be eager loading though, it loads everything all at once
    }
}
