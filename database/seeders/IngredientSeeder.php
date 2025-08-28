<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['ingredient_name' => 'Flour'],
            ['ingredient_name' => 'Water'],
            ['ingredient_name' => 'Sugar'],
            ['ingredient_name' => 'Butter'],
            ['ingredient_name' => 'Eggs'],
            ['ingredient_name' => 'Milk'],
            ['ingredient_name' => 'Baking Powder'],
            ['ingredient_name' => 'Vanilla Extract'],
            ['ingredient_name' => 'Cocoa Powder'],
            ['ingredient_name' => 'Cinnamon'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::firstOrCreate($ingredient);
        }
    }
}
