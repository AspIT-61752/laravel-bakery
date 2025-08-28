<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentAndLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() < 8) {
            User::factory(8 - User::count())->create();
        }

        $users = User::all();
        $products = Product::all();

        foreach ($products as $product) {
            $commenters = $users->random(rand(1, min(4, $users->count())));

            foreach ($commenters as $commenter) {
                Comment::factory()
                    ->for($commenter)
                    ->for($product)
                    ->create();
            }

            $likers = $users->shuffle()->take(rand(0, min(6, $users->count())))->pluck('id')->all();

            foreach ($likers as $liker) {
                if (!$product->likes()->where('user_id', $liker)->exists()) {
                    $product->likedBy()->syncWithoutDetaching($liker);
                }
            }
        }
    }
}
