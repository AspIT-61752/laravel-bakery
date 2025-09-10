<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Laravel DB Seeder
    // https://laravel.com/docs/12.x/seeding#writing-seeders

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        $this->call([
            ProductTypeSeeder::class,
            IngredientSeeder::class,
            ProductSeeder::class,
            PivotSeeder::class,
            CommentAndLikeSeeder::class,
        ]);
    }
}
