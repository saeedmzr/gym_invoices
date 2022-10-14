<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\SimpleResource;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Auth\AuthResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class AuthController extends Controller
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $loginRequest): SimpleResource|AuthResource
    {
        $user = $this->userRepository->login($loginRequest->email, $loginRequest->password);
        if (!$user) return new SimpleResource(['message' => 'your credentials doesnt seems to be right.', 'status' => 404]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return new AuthResource(['access_token' => $token]);
    }

    public function get(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function logout(): SimpleResource
    {
        auth()->user()->tokens()->delete();
        return new SimpleResource(['message' => 'you Logged out.', 'status' => 200]);
    }


}
