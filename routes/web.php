<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
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
    Route::get('/admin', [AdminPageController::class, 'admin'])->name('admin.dashboard');

    // Because of how I get the data for the selected user, I have to go through that, before I can show the page. That's why I can't use admin.users
    // editUser returns the data to the view
    Route::get('/admin/users', [AdminPageController::class, 'editUser'])->name('admin.edit-user');

    Route::get('/admin/products', [AdminPageController::class, 'editProduct'])->name('admin.edit-product');

    Route::get('/admin/settings', [AdminPageController::class, 'settings'])->name('admin.settings');


    // Changes to users
    // Makes a user an admin
    Route::post('/admin/make-admin/{userID}', [AdminPageController::class, 'makeAdmin'])->name('admin.make-admin');

    // Removes admin status from a user
    Route::post('/admin/remove-admin/{userID}', [AdminPageController::class, 'removeAdmin'])->name('admin.remove-admin');

    // Remove user from the system
    // TODO: add confirmation!
    Route::delete('/admin/remove-user/{userID}', [AdminPageController::class, 'removeUser'])->name('admin.remove-user');

    // Change user info
    Route::put('/admin/change-user-info/{userID}', [AdminPageController::class, 'changeUserInfo'])->name('admin.change-user-info');

    /// Product management

    // Create a new product
    Route::get('/admin/products/create', [AdminPageController::class, 'addProductPage'])->name('admin.create-product');

    // Edit a product
    Route::put('/admin/edit-product-info/{prodID}', [AdminPageController::class, 'editProductInfo'])->name('admin.edit-product-info');

    // Remove a product
    Route::delete('/admin/remove-product/{prodID}', [AdminPageController::class, 'removeProduct'])->name('admin.remove-product');

    // For getting the selected ID
    Route::get('/admin/edit-user', [AdminPageController::class, 'editUser'])->name('admin.edit-user');

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
