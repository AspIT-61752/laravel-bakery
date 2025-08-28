<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductIngredient extends Pivot
{
    use HasFactory;

    protected $table = 'product_ingredient';
    public $timestamps = true;

    public $incrementing = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'ingredient_id',
        'amount',
        'unit',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function ingredient() {
        return $this->belongsTo(Ingredient::class);
    }
}
