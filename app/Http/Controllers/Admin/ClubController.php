<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateClubRequest;
use App\Http\Resources\Club\ClubResource;
use App\Http\Resources\SimpleResource;
use App\Models\Club;
use App\Repositories\Club\ClubRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClubController extends Controller
{
    private ClubRepository $ClubRepository;

    public function __construct(ClubRepository $ClubRepository)
    {
        $this->ClubRepository = $ClubRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $clubs = $this->ClubRepository->all();
        return ClubResource::collection($clubs);
    }

    public function show(Club $club): ClubResource
    {
        return new ClubResource($club);
    }

    public function store(CreateClubRequest $request): ClubResource
    {
        $Club = $this->ClubRepository->create($request->validated());
        return new ClubResource($Club->fresh());
    }


    public function destroy(Club $club): SimpleResource
    {
        $this->ClubRepository->deleteById($club->id);
        return new SimpleResource(['message' => 'Club has been deleted successfully.', 'status' => 200]);
    }


}
