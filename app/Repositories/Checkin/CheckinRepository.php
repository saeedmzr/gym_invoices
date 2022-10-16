<?php

namespace App\Repositories\Checkin;

use App\Models\Checkin;
use App\Models\Club;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CheckinRepository extends BaseRepository
{
    protected $model;

    public function __construct(Checkin $model)
    {
        $this->model = $model;
    }

    public function todayCheckIn($user_id, $club_id)
    {
        return $this->model->query()
            ->where('club_id', $club_id)
            ->whereDate('created_at', Carbon::now())
            ->first();
    }

    public function getLastCheckIn(int $user_id)
    {
        return $this->model->query()
            ->whereHas('invoice', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->latest()->first();
    }

}
