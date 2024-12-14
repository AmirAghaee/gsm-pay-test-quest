<?php

namespace Database\Factories;

use App\Models\LoginLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LoginLog>
 */
class LoginLogFactory extends Factory
{
    protected $model = LoginLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'status' => $this->faker->randomElement(['success', 'failed']),
            'action_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
