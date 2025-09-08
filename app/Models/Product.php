<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // Laravel
    // https://laravel.com/docs/12.x/eloquent#retrieving-or-creating-models
    // https://laravel.com/docs/12.x/eloquent-relationships#many-to-many

    // Laravel DB Seeder
    // https://laravel.com/docs/12.x/seeding#writing-seeders

    // Others
    // https://pineco.de/easy-role-management-pivot-models/
    // https://medium.com/@codebyjeff/custom-pivot-table-models-or-choosing-the-right-technique-in-laravel-fe435ce4e27e

    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentedUsers()
    {
        return $this->belongsToMany(User::class, 'comments')
            ->withPivot('id', 'body', 'created_at')
            ->as('comment')
            ->withTimestamps()
            ->distinct('users.id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')
            ->using(ProductIngredient::class)
            ->withPivot('amount', 'unit')
            ->as('product_ingredient')
            ->withTimestamps();
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes')
            ->using(Like::class)
            ->withTimestamps();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
