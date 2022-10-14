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
            'total_amount' => $this->calculateTotalAmount(),
            'total_check_in' =>  $this->invoice_lines ?  count($this->invoice_lines) : 0 ,
            'membership_check_in_count' => $this->calculateMembershipCount(),
            'guest_check_in_count' => $this->calculateGuestCount(),
            'status' => $this->status,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'invoice_lines' => $this->invoice_lines,

        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
