<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateJwt
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $userId = JWTAuth::parseToken()->getPayload()->get('sub');

            if (!$userId) {
                return ApiResponse::error(['message' => 'Token is invalid or expired'], 401);
            }

            $request->attributes->add(['user_id' => $userId]);
        } catch (JWTException $e) {
            return ApiResponse::error(['message' => 'Token is invalid or expired'], 401);
        }

        return $next($request);
    }
}
