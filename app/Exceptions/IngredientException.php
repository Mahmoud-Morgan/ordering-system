<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class IngredientException extends Exception
{

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
    /**
     * Render the exception into an HTTP response.
     */
    public function render($request = null): JsonResponse
    {
        return response()->json([
            'error' => 'insufficient ingredients',
        ], Response::HTTP_CONFLICT); // 409 status code
    }
}
