<?php

namespace App\Providers;

use App\Repositories\IIngredientRepository;
use App\Repositories\Implementations\IngredientRepository;
use App\Repositories\Implementations\OrderRepository;
use App\Repositories\Implementations\ProductRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IIngredientRepository::class, IngredientRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
    }

}
