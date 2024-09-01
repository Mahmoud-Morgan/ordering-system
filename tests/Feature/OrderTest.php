<?php

namespace Tests\Feature;

use App\Exceptions\IngredientException;
use App\Jobs\IngredientStockAlertJob;
use App\Mail\IngredientStockAlertMail;
use App\Services\Implementations\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;


class OrderTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;
    /**
     * A basic feature test example.
     */
    public function test_create(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('ingredient_product')->truncate();
        DB::table('products')->truncate();
        DB::table('ingredients')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->artisan('db:seed');

        $order = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 2,
                ],
            ]
        ];
        $this->post('api/order',$order)
            ->assertStatus(201);
    }



    public function test_create_alert_job_with_over_50_amount(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('ingredient_product')->truncate();
        DB::table('products')->truncate();
        DB::table('ingredients')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->artisan('db:seed');

        Bus::fake();
        $order = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 40,
                ],
            ]
        ];
        $this->post('api/order',$order)
            ->assertStatus(201);


        Bus::assertDispatched(IngredientStockAlertJob::class);
    }


    public function test_create_alert_mail_with_over_50_amount(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('ingredient_product')->truncate();
        DB::table('products')->truncate();
        DB::table('ingredients')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->artisan('db:seed');

        Mail::fake();

        $order = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 40,
                ],
            ]
        ];
        $this->post('api/order',$order)
            ->assertStatus(201);

        Mail::assertSent(IngredientStockAlertMail::class, function ($mail) {
            return $mail->hasTo(config('mail.merchant'));
        });
    }


    public function test_create_with_insufficient_ingredients()
    {

        $this->artisan('db:seed');
        // Expecting IngredientException to be thrown
        $this->expectException(IngredientException::class);
        $this->expectExceptionMessage('insufficient ingredients');

        $orderService = app(OrderService::class);

        $orderService->createOrder([
            'products' => [
                [
                    'product_id' => 1,
                    'quantity' => 200,
                ],
            ],
        ]);
    }

}
