<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_name'
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'product_ingredient')
            ->using(ProductIngredient::class)
            ->withPivot('amount', 'unit')
            ->as('product_ingredient')
            ->withTimestamps();
    }
}
