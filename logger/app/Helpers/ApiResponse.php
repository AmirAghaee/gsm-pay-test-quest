<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(array $data = [], int $code = 200): JsonResponse
    {
        return response()->json(['data' => $data, 'server_time' => requestTimeInIso()], $code);
    }

    public static function error(array $data, int $code = 422): JsonResponse
    {
        return response()->json(['data' => $data, 'server_time' => requestTimeInIso()], $code);
    }
}
