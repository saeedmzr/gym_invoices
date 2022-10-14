<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class MembershipFactory extends Factory
{

    public function definition()
    {
        $users = User::all()->pluck('id')->toArray() ;
        $clubs = Club::all()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users) ,
            'club_id' => $this->faker->randomElement($clubs) ,
            'credits' => $this->faker->numberBetween(10,30) ,
            'status' => $this->faker->randomElement(['Active','Cancelled']) ,
            'start_at' => $this->faker->date(),
            'expire_at' => $this->faker->date(),
        ];
    }
}
