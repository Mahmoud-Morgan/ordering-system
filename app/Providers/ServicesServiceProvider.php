<?php

namespace App\Providers;

use App\Services\Implementations\OrderService;
use App\Services\IOrderService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IOrderService::class, OrderService::class);
    }
}
