<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createdAt = Carbon::now()->format('Y-m-d H:i:s');
        $ingredients = [
            ['name' => 'Beef', 'initial_stock_amount'=> 20000, 'current_stock_amount'=> 20000, 'created_at' => $createdAt],
            ['name' => 'Cheese', 'initial_stock_amount'=> 5000, 'current_stock_amount'=> 5000, 'created_at' => $createdAt],
            ['name' => 'Onion', 'initial_stock_amount'=> 1000, 'current_stock_amount'=> 1000, 'created_at' => $createdAt],
        ];
        Ingredient::insert($ingredients);
    }
}
