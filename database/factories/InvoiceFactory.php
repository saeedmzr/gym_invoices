<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{

    public function definition()
    {
        $clubs = Club::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();
        return [
            'club_id' => $this->faker->randomElement($clubs),
            'user_id' => $this->faker->randomElement($users),
            'status' => $this->faker->randomElement(array('Outstanding', 'Paid', 'Void')),
            'description' => $this->faker->text(),
            'amount' => $this->faker->numberBetween(12000,12000),
        ];
    }
}
