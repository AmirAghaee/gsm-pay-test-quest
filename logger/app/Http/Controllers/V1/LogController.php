<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    public function index(): JsonResponse
    {
        $logs = LoginLog::where('user_id', request()->get('user_id'))->get();

        return ApiResponse::success(['logs' => $logs]);
    }
}

