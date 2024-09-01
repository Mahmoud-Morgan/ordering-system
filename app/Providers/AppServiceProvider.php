<?php

namespace App\Providers;

use App\Events\IngredientStockAlertEvent;
use App\Exceptions\IngredientException;
use App\Listeners\IngredientStockAlertListener;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            IngredientStockAlertEvent::class,
            IngredientStockAlertListener::class,
        );


        app()->bind(ExceptionHandler::class, function ($app) {
            return new class($app) extends Handler {
                public function render($request, \Throwable $e)
                {
                    if ($e instanceof IngredientException) {
                        return response()->json(['error' => 'Insufficient ingredients'], Response::HTTP_CONFLICT);
                    }

                    return parent::render($request, $e);
                }
            };
        });
    }
}
