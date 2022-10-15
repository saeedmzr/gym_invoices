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
            'cost_per_check_in' => $this->cost_per_check_in,
            'check_in_count' => $this->check_in_count,
        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
