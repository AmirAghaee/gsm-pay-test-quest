<?php

namespace Tests\Feature;

use App\Jobs\UserLoginEventJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_successful(): void
    {
        Queue::fake();

        // Create a test user
        $user = User::factory()->create([
            'phone_number' => '09378239592',
            'password' => Hash::make('password123'),
        ]);

        // Make a login request
        $response = $this->postJson(route('login'), [
            'phone_number' => '09378239592',
            'password' => 'password123',
        ]);

        // Assert the response is successful
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
            ],
            'server_time',
        ]);

        // Assert that the job was dispatched with the correct data
        Queue::assertPushed(UserLoginEventJob::class, function ($job) use ($user) {
            return $job->message['user_id'] === $user->id && $job->message['status'] === 'success';
        });
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        Queue::fake(); // Fake the job queue

        // Create a test user
        $user = User::factory()->create([
            'phone_number' => '12345678901',
            'password' => Hash::make('password123'),
        ]);

        // Attempt to log in with invalid credentials
        $response = $this->postJson(route('login'), [
            'phone_number' => '12345678901',
            'password' => 'wrong-password',
        ]);

        // Assert the response indicates failure
        $response->assertStatus(401)
            ->assertJson([
                'data' => [
                    'message' => 'Invalid phone number or password',
                ],
            ]);

        // Assert that the job was dispatched with a failed status
        Queue::assertPushed(UserLoginEventJob::class, function ($job) use ($user) {
            return $job->message['user_id'] === $user->id
                && $job->message['status'] === 'failed';
        });
    }

    public function test_login_fails_with_nonexistent_user(): void
    {
        Queue::fake();

        // Attempt to log in with a non-existent user
        $response = $this->postJson(route('login'), [
            'phone_number' => '12345678901',
            'password' => 'password123',
        ]);

        // Assert the response indicates failure
        $response->assertStatus(401)
            ->assertJson([
                'data' => [
                    'message' => 'Invalid phone number or password',
                ],
            ]);

        // Assert that the job was dispatched with a failed status and null user_id
        Queue::assertPushed(UserLoginEventJob::class, function ($job) {
            return $job->message['user_id'] === null && $job->message['status'] === 'failed';
        });
    }

}
