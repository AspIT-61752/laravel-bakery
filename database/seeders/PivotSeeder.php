<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['g', 'ml', 'l', 'cup', 'tbsp', 'tsp', 'pinch', 'oz', 'kg', 'lb', ''];

        $products = Product::all();
        $ingredients = Ingredient::all();

        if ($products->isEmpty() || $ingredients->isEmpty()) {
            // Ensure there are products and ingredients to associate
            return;
        }

        foreach ($products as $product) {
            $picked = $ingredients->random((min($ingredients->count(), rand(4, 8))));

            $add = [];
            foreach ($picked as $i) {
                $add[$i->id] = [
                    'amount' => fake()->randomFloat(2, 1, 500),
                    'unit' => $units[array_rand($units)],
                    'created_at' => now(),
                ];
            }

            $product->ingredients()->syncWithoutDetaching($add);
        }
    }
}
