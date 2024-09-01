<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function productIngredients(): HasMany
    {
        return $this->hasMany(IngredientProduct::class, 'product_id', 'id');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('amount');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

}
