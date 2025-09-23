<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        return view('admin.products', compact('products'));
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
        // dd($userID);
        $user = User::find($userID);
        if ($user) {
            // Update user info based on request data
            $user->name = request('name') ?? $user->name;
            $user->email = request('email') ?? $user->email;
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
        return view('admin.add-product');
    }


    // Show the edit user page
    public function editUser(Request $request)
    {
        $editID = $request->query('edit_id');
        $users = User::all();
        $selectUser = $editID ? User::find($editID) : null;
        if ($users) {
            return view('admin.users', ['dataType' => 'user', 'users' => $users, 'selectedItem' => $selectUser]);
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

    // Gets the data needed for the edit product page
    public function editProduct(Request $request)
    {
        $editID = $request->query('edit_id');
        $products = Product::all();
        $selectedProduct = $editID ? Product::find($editID) : null;
        if ($products) {
            return view('admin.products', ['dataType' => 'product', 'products' => $products, 'selectedItem' => $selectedProduct]);
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
