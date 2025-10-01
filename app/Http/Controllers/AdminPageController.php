<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ImageUploadService;
// use Illuminate\Support\Facades\Log;

class AdminPageController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        $products = Product::all();
        // Gets data for the product edit form
        $productTypes = ProductType::all();
        $ingredients = Ingredient::all();
        return view('admin.products', compact('products', 'productTypes', 'ingredients'));
    }

    public function settings()
    {
        $settings = "Site settings would go here";
        return view('admin.settings', compact('settings'));
    }

    /// Changes to users ///

    // Makes a user an admin
    public function makeAdmin($userID)
    {
        // dd($userID);
        $user = User::find($userID);
        if ($user) {
            $user->is_admin = true;
            $user->save();
            return redirect()->back()->with('success', "User {$user->name} is now an admin.");
        } else {
            return redirect()->back()->with('error', "User not found.");
        }
    }

    // Removes admin status from a user
    public function removeAdmin($userID)
    {
        $user = User::find($userID);
        if ($user) {
            $user->is_admin = false;
            $user->save();
            return redirect()->back()->with('success', "User {$user->name} is no longer an admin.");
        } else {
            return redirect()->back()->with('error', "User not found.");
        }
    }

    // Remove user from the system
    public function removeUser($userID)
    {
        $user = User::find($userID);
        if ($user) {
            $userName = $user->name;
            $user->delete();
            return redirect()->back()->with('success', "User {$userName} has been removed.");
        } else {
            return redirect()->back()->with('error', "User not found.");
        }
    }

    // Change user info
    public function changeUserInfo($userID)
    {
        // dd(request()->all());
        // dd($userID);
        $user = User::find($userID);
        if ($user) {
            // Update user info based on request data
            $user->name = request('name') ?? $user->name;
            $user->email = request('email') ?? $user->email;
            $user->is_admin = request('is_admin') ?? $user->is_admin;
            $user->save();
            return redirect()->back()->with('success', "User {$user->name}'s info has been updated.");
        } else {
            return "User not found.";
        }
    }

    /// Changes to products ///

    // I couldn't think of a good way to show and change products in the admin panel, so I'm making a page for each action (add, edit, except delete)

    // Add a new product
    public function addProductPage()
    {
        $productTypes = ProductType::all();
        $ingredients = Ingredient::all();

        return view('admin.create-product-page', compact('productTypes', 'ingredients'));
    }


    // Show the edit user page
    public function editUser(Request $request)
    {
        $editID = $request->query('edit_id');

        // Gets data for the product edit form
        $productTypes = ProductType::all();
        $ingredients = Ingredient::all();

        $users = User::all();
        $selectUser = $editID ? User::find($editID) : null;
        if ($users) {
            return view('admin.users', ['dataType' => 'user', 'users' => $users, 'selectedItem' => $selectUser, 'productTypes' => $productTypes, 'ingredients' => $ingredients]);
        } else {
            return redirect()->back()->with('error', "Product not found.");
        }
    }

    // Edit a product
    // public function editProductPage($prod)
    // {
    //     // The product page should already have all products on that page, just send the entire product to the view
    //     return view('admin.edit-product', compact('prod'));
    // }

    // Creates a new product
    public function createProduct(Request $request)
    {   // Validate the request data

        $valData = $request->validate([
            'name' => 'required|string|max:255',
            'product_type_id' => 'required|exists:product_types,id',
            'description' => 'nullable|string',
            'recipe' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'ingredients' => 'required|array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);
        // Log::info('Image', ['image' => $request->file('image')]);

        // dd($valData, $request->all());

        // Handle image upload if an image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Get an instance of the image upload service
            $imageUploadService = new ImageUploadService();

            // Upload the image and get the URL
            $imageUrl = $imageUploadService->uploadProductImage($image, $valData['name']);
            // Log::info('Image uploaded to: ' . $imageUrl);
        }

        // Create the product
        $product = new Product();
        $product->name = $valData['name'];

        // Ran into an issue where the slug wasn't being set correctly when creating a new product, so I added this to make sure it'll be unique :)
        $count = 1;
        $baseSlug = Str::slug($valData['name'], '-');
        $slug = $baseSlug;

        // Keeps generating a new slug until it finds one that isn't taken
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        $product->slug = $slug;

        $product->product_type_id = $valData['product_type_id'];
        $product->description = $valData['description'] ?? '';
        $product->recipe = $valData['recipe'];

        if ($imageUrl) {
            $product->image = $imageUrl;
        }

        // You have to save it first, before you can attatch ingredients
        $product->save();

        // Attach ingredients to the product
        foreach ($valData['ingredients'] as $ingredientId) {
            $product->ingredients()->attach($ingredientId, ['amount' => 1, 'unit' => 'g']); // Temporary amount and unit, it's needed because I thought both were required when I created the migration :)
        }

        // Returns to the edit product page so the user can see the product they created
        return redirect()->route('admin.edit-product', ['edit_id' => $product->id])
            ->with('success', "Product {$product->name} has been created successfully.");
    }

    // Gets the data needed for the edit product page
    public function editProduct(Request $request)
    {

        $editID = $request->query('edit_id');
        $products = Product::all();
        $selectedProduct = $editID ? Product::find($editID) : null;

        $productTypes = ProductType::all();
        $ingredients = Ingredient::all();

        if ($products) {
            return view('admin.products', ['dataType' => 'product', 'products' => $products, 'selectedItem' => $selectedProduct, 'productTypes' => $productTypes, 'ingredients' => $ingredients]);
        }
        // The product page should already have all products on that page, just send the entire product to the view
        return view('admin.edit-product', compact('prod'));
    }

    // Updates the product info
    public function editProductInfo($prodID)
    {
        $prod = Product::find($prodID);
        if ($prod) {
            // Update product info based on request data
            $prod->name = request('name') ?? $prod->name;
            $prod->slug = Str::slug($prod->name, '-');
            $prod->product_type_id = request('product_type_id') ?? $prod->product_type_id;
            $prod->description = request('description') ?? $prod->description;

            if (request()->hasFile('image')) {

                // Validates the image
                request()->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,webp'
                ]);

                // Gets and uploads the image
                $image = request()->file('image');

                // Gets an instance of the image upload service
                $imageUploadService = new ImageUploadService();

                // Uploads the image and gets the URL
                $imageUrl = $imageUploadService->uploadProductImage($image, $prod->name);

                // Sets the image URL to the product
                $prod->image = $imageUrl;
            }

            $prod->save();
            return redirect()->back()->with('success', "Product {$prod->name}'s info has been updated.");
        } else {
            return "Product not found.";
        }
    }

    // Delete a product
    // This doesn't need a page, it'll just be a button on the products page
    public function removeProduct($prodID)
    {
        $product = Product::find($prodID);
        if ($product) {
            $productName = $product->name;
            $product->delete();
            return redirect()->back()->with('success', "Product {$productName} has been deleted");
        } else {
            return redirect()->back()->with('error', "Product not found.");
        }
    }
}
