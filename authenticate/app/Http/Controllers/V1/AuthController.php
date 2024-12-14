<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Jobs\UserLoginEventJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('phone_number', 'password');

        if (!$token = auth()->attempt($credentials)) {
            $userId = User::where('phone_number', $credentials['phone_number'])->value('id');
            $this->dispatchUserLoginEvent('failed', $userId);
            return ApiResponse::error(['message' => 'Invalid phone number or password'], 401);
        }

        $this->dispatchUserLoginEvent('success', auth()->id());

        return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    private function dispatchUserLoginEvent(string $status, ?int $userId = null): void
    {
        UserLoginEventJob::dispatch([
            'user_id' => $userId,
            'status' => $status,
            'ip' => request()->ip(),
            'action_at' => requestTimeInIso(),
        ])->onQueue('user-login-event');
    }
}
