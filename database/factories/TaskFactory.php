<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'board_id'    => Board::factory(),
            'user_id'     => User::factory(),
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status'      => $this->faker->randomElement(['todo', 'in_progress', 'done']),
            'due_date'    => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }
}