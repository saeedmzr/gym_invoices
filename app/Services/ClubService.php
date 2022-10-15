<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Checkin\CheckinRepository;
use App\Repositories\Club\ClubRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Membership\MembershipRepository;

class ClubService
{
    private $clubRepository;
    private $membershipRepository;
    private $invoiceRepository;
    private $checkinRepository;

    public function __construct(
        ClubRepository       $clubRepository,
        MembershipRepository $membershipRepository,
        InvoiceRepository    $invoiceRepository,
        CheckinRepository    $checkinRepository
    )
    {
        $this->clubRepository = $clubRepository;
        $this->membershipRepository = $membershipRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->checkinRepository = $checkinRepository;
    }

    public function checkIn($club_id, User $user)
    {

        $check_in_result = $this->checkinRepository->todayCheckIn($user->id, $club_id);
        if ($check_in_result) return ['result' => false, 'message' => "You can't check-in in a club twice a day."];

        $club = $this->clubRepository->findById($club_id);
        $cost_per_check_in = $club->cost_per_check_in;

        $membership = $this->membershipRepository->getAvailableMembership($club, $user);
        $invoice = $this->invoiceRepository->createInvoiceForAUserIfNotExists($club, $user, $membership);


        if ($membership) {
            $membership->update(['credits' => $membership->credits - 1]);
            $description = 'Checked in as a membership';
        } else {
            $invoice->amount = $invoice->amount + $cost_per_check_in;
            $invoice->status = 'Outstanding';
            $description = 'Checked in as a guest';
        }

        $invoice->checkins()->create([
            'club_id' => $club->id,
            'amount' => $cost_per_check_in,
            'description' => $description,
            'type' => ($membership ? "membership" : "guest")
        ]);
        $invoice->save();

        $club->update(['check_in_count' => $club->check_in_count + 1]);


        return ['result' => true, 'data' => $invoice];
    }
}
