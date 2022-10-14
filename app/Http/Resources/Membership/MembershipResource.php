<?php

namespace App\Http\Resources\Membership;

use App\Http\Resources\Admin\Role\RoleResource;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Club\ClubResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    public static $wrap = null;


    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'club' => new ClubResource($this->club),
            'user' => new UserResource($this->user),
            'status' => $this->status,
            'credits' => $this->credits,
            'start_at' => $this->start_at,
            'expire_at' => $this->expire_at,
        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
