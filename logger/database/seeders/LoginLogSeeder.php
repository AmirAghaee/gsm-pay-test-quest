<?php

namespace Database\Seeders;

use App\Models\LoginLog;
use Illuminate\Database\Seeder;

class LoginLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoginLog::factory(50)->create();
    }
}
