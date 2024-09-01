<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface IOrderService
{

    public function createOrder(array $data);

    public function orderCheckIngredients(Collection $products ,array $data ): array;

    public function consumeIngredients(array $orderIngredients): void;
}
