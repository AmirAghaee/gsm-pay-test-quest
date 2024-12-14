<?php

namespace App\Jobs;

use App\Models\LoginLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserLoginEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        LoginLog::create([
            'user_id' => $this->message['user_id'] ?? null,
            'status' => $this->message['status'],
            'action_at' => $this->message['action_at'],
        ]);
    }
}
