<?php

namespace Tests\Feature;

use App\Models\LoginLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_login_logs_for_authenticated_user()
    {
        // Seed the database with test data
        $userId = 123;
        $user = new User($userId);

        // Generate a token for the user
        $token = JWTAuth::fromUser($user);

        // Create 3 login logs for this user
        LoginLog::factory()->count(3)->create(['user_id' => $userId]);

        // Create 2 login logs for a different user
        LoginLog::factory()->count(2)->create(['user_id' => 999]);

        // Send GET request with the token
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson(route('logs.index'));

        // Assert status is 200
        $response->assertStatus(200);

        // Assert the correct data is returned
        $response->assertJsonCount(3, 'data.logs');
        $response->assertJsonStructure([
            'data' => [
                'logs' => [
                    '*' => [
                        'id',
                        'user_id',
                        'status',
                        'action_at',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
            'server_time',
        ]);

        // Assert the logs belong to the correct user
        $response->assertJsonFragment(['user_id' => $userId]);
    }

    public function test_it_returns_error_for_invalid_token()
    {
        $response = $this->getJson(route('logs.index'));

        // Assert status is 401 (Unauthorized)
        $response->assertStatus(401);

        // Assert error message is returned
        $response->assertJsonFragment(['message' => 'Token is invalid or expired']);
    }
}
