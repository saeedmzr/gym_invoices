<?php

namespace App\Repositories\Club;

use App\Models\Club;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ClubRepository extends BaseRepository
{
    protected $model;

    public function __construct(Club $model)
    {
        $this->model = $model;
    }


}
