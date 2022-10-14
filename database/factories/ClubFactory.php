<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'cost_per_check_in' => $this->faker->numberBetween('1200','1400'),
        ];
    }
}
