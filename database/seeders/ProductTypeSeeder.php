<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type_name' => 'Bread'],
            ['type_name' => 'Cookies'],
            ['type_name' => 'Cupcakes'],
            ['type_name' => 'Cake'],
            ['type_name' => 'Layer cakes'],
            ['type_name' => 'Roulades'],
            ['type_name' => 'Pastry'],

        ];

        foreach ($types as $type) {
            ProductType::firstOrCreate($type);
        }
    }
}
