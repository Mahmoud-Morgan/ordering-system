<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IngredientProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beef = Ingredient::where('name', 'Beef')->first();
        $cheese = Ingredient::where('name', 'Cheese')->first();
        $onion = Ingredient::where('name', 'Onion')->first();

        $product = Product::where('name', 'Burger')->first();

        $createdAt = Carbon::now()->format('Y-m-d H:i:s');

        $ProductIngredients = [
            [
                'product_id' => $product->id,
                'ingredient_id' => $beef->id,
                'amount' =>150,
                'created_at' => $createdAt,
            ],
            [
                'product_id' => $product->id,
                'ingredient_id' => $cheese->id,
                'amount' => 30,
                'created_at' => $createdAt,
            ],
            [
                'product_id' => $product->id,
                'ingredient_id' => $onion->id,
                'amount' => 20,
                'created_at' => $createdAt,
            ]
        ];

        IngredientProduct::insert($ProductIngredients);

    }
}
