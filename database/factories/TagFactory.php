<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $colors = ['#EF4444','#F59E0B','#10B981','#3B82F6','#8B5CF6','#EC4899'];

        return [
            'name'  => $this->faker->unique()->word(),
            'color' => $this->faker->randomElement($colors),
        ];
    }
}