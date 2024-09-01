<?php

namespace App\Listeners;

use App\Events\IngredientStockAlertEvent;
use App\Jobs\IngredientStockAlertJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IngredientStockAlertListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IngredientStockAlertEvent $event): void
    {
        IngredientStockAlertJob::dispatch(config('mail.merchant'), $event->ingredientName);
    }
}
