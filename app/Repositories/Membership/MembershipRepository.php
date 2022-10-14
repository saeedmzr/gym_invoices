<?php

namespace App\Repositories\Membership;

use App\Models\Club;
use App\Models\Membership;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MembershipRepository extends BaseRepository
{

    protected $model;

    public function __construct(Membership $model)
    {
        $this->model = $model;
    }

    public function getAvailableMembership(Club $club, User $user): bool|Membership
    {
        $cost_per_check_in = $club->cost_per_check_in;

        $membership = $this->model->query()
            ->where('start_at', '<', Carbon::now())
            ->where('expire_at', '>', Carbon::now())
            ->where('club_id', $club->id)
            ->where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('credits', '>=', 1)
            ->first();

        if (!$membership) return false;
        return $membership;
    }


}
