<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Main landing page
// Route::get('/', function () {
//     return view('laravel');
// });



Route::get('/', [PageController::class, 'index'])->name('frontpage');

Route::get('/products/{product:slug}', [PageController::class, 'recipe'])->name('products.recipe');

// Products and their subpages
Route::middleware(['auth'])->group(function () {

    // Main landing page
    // Route::get('/', [PageController::class, 'index'])->name('frontpage');

    // Product recipe page
    // Route::get('/products/{product:slug}', [PageController::class, 'recipe'])->name('products.recipe');
    // This should probably be on a component? Or something that uses the @auth thing in Blade

    // Find a way to make this work without auth middleware so the product page are accessible to everyone, but the commenting system is only for logged in users
    // Route::post('/products/{product:slug}/comments', [CommentController::class, 'store'])->name('products.comments.store');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User handeling and editing
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
