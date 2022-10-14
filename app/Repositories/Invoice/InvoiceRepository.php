<?php

namespace App\Repositories\Invoice;

use App\Models\Club;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvoiceRepository extends BaseRepository
{
    protected $model;

    public function __construct(Invoice $model)
    {
        $this->model = $model;
    }

    public function createInvoiceForAUserIfNotExists(Club $club, User $user): bool|Invoice
    {

        $invoice = $this->model->query()
            ->where('club_id', $club->id)
            ->where('user_id', $user->id)
            ->where('status', 'Outstanding')
            ->first();

        if (!$invoice) $invoice = $this->model->query()->create(['club_id' => $club->id, 'user_id' => $user->id]);
        return $invoice;
    }

    public function userInvoices(User $user)
    {
        return $user->invoices();
    }


}
