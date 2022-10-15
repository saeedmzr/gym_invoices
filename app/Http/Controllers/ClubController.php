<?php

namespace App\Http\Controllers;

use App\Http\Requests\Club\CheckInRequest;
use App\Http\Resources\Club\ClubResource;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Http\Resources\SimpleResource;
use App\Repositories\Checkin\CheckinRepository;
use App\Repositories\Club\ClubRepository;
use App\Services\ClubService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClubController extends Controller
{
    private ClubRepository $clubRepository;
    private ClubService $clubService;

    public function __construct(ClubRepository $clubRepository, ClubService $clubService )
    {
        $this->clubRepository = $clubRepository;
        $this->clubService = $clubService;
    }

    public function index(): AnonymousResourceCollection
    {
        $clubs = $this->clubRepository->all();
        return ClubResource::collection($clubs);
    }

    public function checkIn(CheckInRequest $checkInRequest): SimpleResource|InvoiceResource
    {
        $invoice_result = $this->clubService->checkIn($checkInRequest->club_id, auth()->user());
        if (!$invoice_result['result']) return new SimpleResource(['message' => $invoice_result['message'], 'status' => 406]);


        return new InvoiceResource($invoice_result['data']);
    }

}
