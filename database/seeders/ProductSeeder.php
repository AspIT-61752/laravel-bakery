<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ProductSelection = [
            'Rye Bread' => 'Bread',
            'Chocolate Chip Cookies' => 'Cookies',
            'Vanilla Cupcakes' => 'Cupcakes',
            'Red Velvet Cake' => 'Cake',
            'Chocolate Layer Cake' => 'Layer cakes',
            'Swiss Roll' => 'Roulades',
            'Apple Pie' => 'Pastry',
        ];

        foreach ($ProductSelection as $productName => $productType) {
            Product::firstOrCreate([
                'product_type_id' => ProductType::where('type_name', $productType)->firstOrFail()->value('id'),
                'name' => $productName,
                'slug' => Str::slug($productName, '-'),
                'description' => 'Idk, something about the process here',
                'recipe' => 'Figure out how to do this later',
                'image' => null,
            ]);
        }
    }
}
