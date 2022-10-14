<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Resources\SimpleResource;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this->userRepository->all();
        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(CreateUserRequest $request): UserResource
    {
        $user = $this->userRepository->create($request->validated());
        return new UserResource($user->fresh());
    }


    public function destroy(User $user): SimpleResource
    {
        $this->userRepository->deleteById($user->id);
        return new SimpleResource(['message' => 'User has been deleted successfully.', 'status' => 200]);
    }


}
