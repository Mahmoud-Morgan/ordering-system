<?php

namespace App\Services\Implementations;

use App\Events\IngredientStockAlertEvent;
use App\Exceptions\IngredientException;
use App\Repositories\IIngredientRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IProductRepository;
use App\Services\IOrderService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class OrderService implements IOrderService
{

    private IOrderRepository $orderRepository;
    private IProductRepository $productRepository;

    public function __construct(
        IProductRepository $productRepository,
        IOrderRepository   $orderRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }


    public function createOrder(array $data)
    {
//        DB::transaction(function () use ($data) {

            $productIds = array_column($data['products'], 'product_id');
            // Lock rows for update
            $products = $this->productRepository->with('ingredients')
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get();

            $orderIngredients = $this->orderCheckIngredients($products, $data);

            $this->consumeIngredients($orderIngredients);

            $productsQuantity = [];

            foreach ($data['products'] as $product) {
                $productsQuantity[$product['product_id']] = ['quantity' => $product['quantity']];
            }
            $order = $this->orderRepository->create([]);
            $order->products()->sync($productsQuantity);

//        });

    }


    /**
     * @throws IngredientException
     * @throws Exception
     */
    public function orderCheckIngredients(Collection $products, array $data): array
    {
        $totalAmounts = [];
        $ingredients = collect();

        foreach ($data['products'] as $item) {
            $product = $products->where('id', $item['product_id'])->first();

            foreach ($product->ingredients as $ingredient) {
                if (!isset($totalAmounts[$ingredient->id])) {
                    $totalAmounts[$ingredient->id] = 0;
                    $ingredients->push($ingredient);
                }
                $totalAmounts[$ingredient->id] += $ingredient->pivot->amount * $item['quantity'];
                if ($totalAmounts[$ingredient->id] > $ingredient->current_stock_amount) {
                    throw new IngredientException('insufficient ingredients', Response::HTTP_CONFLICT);
                }
            }
        }
        return ['totalAmounts' => $totalAmounts, 'ingredients' => $ingredients];
    }


    public function consumeIngredients(array $orderIngredients): void
    {
        $totalAmounts = $orderIngredients['totalAmounts'];
        $ingredients = $orderIngredients['ingredients'];

        foreach ($totalAmounts as $id => $amount) {
            $ingredient = $ingredients->where('id', $id)->first();
            $ingredient->current_stock_amount -= $amount;
            if (
                $ingredient->current_stock_amount <= ($ingredient->initial_stock_amount * 0.5)
                && $ingredient->stock_alert_sent == 0
            ) {
                IngredientStockAlertEvent::dispatch($ingredient->name);
                $ingredient->stock_alert_sent = 1;
            }

            $ingredient->save();
        }
    }
}
