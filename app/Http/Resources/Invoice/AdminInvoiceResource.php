<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Club\ClubResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminInvoiceResource extends JsonResource
{
    public static $wrap = null;


    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'club' => new ClubResource($this->club),
            'amount_to_pay' => $this->amount,
            'total_amount' => $this->checkins()->sum('amount'),
            'total_check_in' =>  $this->checkins()->count(),
            'membership_check_in_count' => $this->checkins()->where('type','Membership')->count(),
            'guest_check_in_count' => $this->checkins()->where('type','Guest')->count(),
            'status' => $this->status,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'invoice_lines' =>  CheckinResource::collection($this->checkins ),

        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
