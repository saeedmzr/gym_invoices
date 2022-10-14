<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateMembershipRequest;
use App\Http\Resources\Membership\MembershipResource;
use App\Http\Resources\SimpleResource;
use App\Models\Membership;
use App\Repositories\Membership\MembershipRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MembershipController extends Controller
{
    private MembershipRepository $membershipRepository;

    public function __construct(MembershipRepository $membershipRepository)
    {
        $this->membershipRepository = $membershipRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $memberships = $this->membershipRepository->all();
        return MembershipResource::collection($memberships);
    }

    public function show(Membership $membership): MembershipResource
    {
        return new MembershipResource($membership);
    }

    public function store(CreateMembershipRequest $request): MembershipResource
    {
        $Membership = $this->membershipRepository->create($request->validated());
        return new MembershipResource($Membership->fresh());
    }

    public function update(CreateMembershipRequest $request, Membership $membership): MembershipResource
    {
         $this->membershipRepository->update($membership->id, $request->validated());
        return new MembershipResource($membership->fresh());
    }


    public function destroy(Membership $membership): SimpleResource
    {
        $this->membershipRepository->deleteById($membership->id);
        return new SimpleResource(['message' => 'Membership has been deleted successfully.', 'status' => 200]);
    }


}
