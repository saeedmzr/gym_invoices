<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Membership\MembershipResource;
use App\Http\Resources\SimpleResource;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Auth\AuthResource;
use App\Repositories\User\UserRepository;


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

        if ($user->is_admin != 1) return new SimpleResource(['message' => 'You are not an admin.', 'status' => 403]);

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
