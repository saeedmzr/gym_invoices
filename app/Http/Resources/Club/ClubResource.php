<?php

namespace App\Http\Resources\Club;

use App\Http\Resources\Admin\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
{
    public static $wrap = null;


    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'membership_cost' => $this->membership_cost,
        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
