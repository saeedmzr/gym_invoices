<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => '11111111',
        ]);

        $response->assertStatus(200);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create();

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(422);
    }
}
