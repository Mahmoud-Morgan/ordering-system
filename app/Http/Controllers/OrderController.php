<?php

namespace App\Http\Controllers;

use App\Exceptions\IngredientException;
use App\Http\Requests\OrderRequest;
use App\Services\IOrderService;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends Controller
{
    private IOrderService $orderService;
    public function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    /**
     * @param OrderRequest $request
     * @return JsonResponse
     *
     */
    public function create(OrderRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $this->orderService->createOrder($data);
            return response()->json(['message' => 'order created successfully'], Response::HTTP_CREATED);
        } catch (IngredientException|Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }


}
