<?php

namespace App\Repositories\Implementations;

use App\Models\Ingredient;
use App\Repositories\IIngredientRepository;

class IngredientRepository extends Repository implements IIngredientRepository
{
    public function __construct(Ingredient $ingredient)
    {
        $this->setModel($ingredient);
    }

}
