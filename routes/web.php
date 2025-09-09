<?php

use App\Http\Controllers\CommentController;
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

    // Comments on products
    // Has to be inside the auth middleware so only logged in users can comment
    Route::post('/products/{product}/comments', [CommentController::class, 'submit'])->name('products.comments.submit');
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
