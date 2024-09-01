<?php

namespace App\Jobs;

use App\Mail\IngredientStockAlertMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class IngredientStockAlertJob implements ShouldQueue
{
    use Queueable;

    public string $mailTo;
    public string $ingredientName;
    /**
     * Create a new job instance.
     */
    public function __construct(string $mailTo, string $ingredientName)
    {
        $this->mailTo = $mailTo;
        $this->ingredientName = $ingredientName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $email = new IngredientStockAlertMail($this->ingredientName);
            Mail::to($this->mailTo)->send($email);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
