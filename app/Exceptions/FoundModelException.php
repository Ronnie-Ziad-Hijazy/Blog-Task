<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class FoundModelException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'error' => 'Post not exist.',
        ], 404); // Not Found
    }

}
