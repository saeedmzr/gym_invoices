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

    public function createInvoiceForAUserIfNotExists(Club $club, User $user, $membership): bool|Invoice
    {


        $invoice = $this->model->query()
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('club_id', $club->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$invoice) {
            $description = 'Invoice item for ' . $user->name . ' in ' . $club->name . ' Club';
            $invoice = $this->model->query()->create(['club_id' => $club->id, 'user_id' => $user->id, 'description' => $description]);
            if ($membership) $invoice->update(['status' => 'Paid']);
        }

        return $invoice;
    }


}
