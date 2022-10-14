<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Club\ClubRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Membership\MembershipRepository;

class ClubService
{
    private $clubRepository;
    private $membershipRepository;
    private $invoiceRepository;

    public function __construct(
        ClubRepository       $clubRepository,
        MembershipRepository $membershipRepository,
        InvoiceRepository    $invoiceRepository
    )
    {
        $this->clubRepository = $clubRepository;
        $this->membershipRepository = $membershipRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function checkIn($club_id, User $user)
    {
        $club = $this->clubRepository->findById($club_id);
        $cost_per_check_in = $club->cost_per_check_in;

        $membership = $this->membershipRepository->getAvailableMembership($club, $user);
        $invoice = $this->invoiceRepository->createInvoiceForAUserIfNotExists($club, $user, $membership);

        $invoice_lines = $invoice->invoice_lines;

        if ($membership) {
            $membership->update(['credits' => $membership->credits - 1]);
            $description = 'Checked in as a membership';
        } else {
            $invoice->amount = $invoice->amount + $cost_per_check_in;
            $invoice->status = 'Outstanding';
            $description = 'Checked in as a guest';
        }

        $invoice_lines[] = ['amount' => $cost_per_check_in, 'description' => $description, 'type' => ($membership ? "membership" : "guest")];

        $invoice->invoice_lines = $invoice_lines;
        $invoice->save();


        return $invoice;
    }
}
