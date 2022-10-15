<?php

namespace App\Repositories\Checkin;

use App\Models\Checkin;
use App\Models\Club;
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
            ->whereDay('created_at', Carbon::now()->day)
            ->first();
    }

}
