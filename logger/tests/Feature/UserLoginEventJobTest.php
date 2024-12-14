<?php

namespace Tests\Feature;

use App\Jobs\UserLoginEventJob;
use App\Models\LoginLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginEventJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_login_log_entry()
    {
        $message = [
            'user_id' => 1,
            'status' => 'success',
            'action_at' => now()->toDateTimeString(),
        ];

        // Dispatch the job
        dispatch(new UserLoginEventJob($message));

        // Assert the database has one LoginLog entry with the given message data
        $this->assertDatabaseHas('login_logs', [
            'user_id' => $message['user_id'],
            'status' => $message['status'],
            'action_at' => $message['action_at'],
        ]);

        $log = LoginLog::firstWhere('user_id', $message['user_id']);
        $this->assertNotNull($log);
        $this->assertEquals($message['status'], $log->status);
        $this->assertEquals($message['action_at'], $log->action_at);
    }

    public function test_it_handles_missing_message_data()
    {
        // Dispatch the job without the `user_id`
        $message = [
            'status' => 'failed',
            'action_at' => now()->toDateTimeString(),
        ];
        dispatch(new UserLoginEventJob($message));

        // Assert the database has one LoginLog entry with null `user_id`
        $this->assertDatabaseHas('login_logs', [
            'user_id' => null,
            'status' => $message['status'],
            'action_at' => $message['action_at'],
        ]);
    }
}
