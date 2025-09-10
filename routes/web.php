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

// Admin routes
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Admin dashboard or other admin routes can be defined here
    // https://laravel.com/docs/12.x/authorization#generating-policies
    // https://laravel.com/docs/12.x/authorization#gate-responses

    // https://laravel.com/docs/12.x/authorization#via-middleware
    // I think I can just use the 'can' middleware to restrict access to admin users
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    // Looks like this works, I just have to figure out how to make a user an admin
    // I think I can just add something like a boolean 'is_admin' column to the users table.
    // That didn't work, I might have to make a policy and a gate for it as well
    // Anyways, I added a migration to add it to the users table. I still have to edit it manually in the database for now with tinker, I can probably change it in the admin dashboard later or just add it to the seeder
    // For now, use:
    // $user = \App\Models\User::find(1); // Note, user ID 1 is just the test user
    // $user->is_admin = true;
    // $user->save();
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
