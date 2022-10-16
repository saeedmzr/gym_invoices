<?php

namespace Tests\Feature;

use App\Models\Checkin;
use App\Models\Club;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\User;
use App\Repositories\Checkin\CheckinRepository;
use App\Repositories\Club\ClubRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Membership\MembershipRepository;
use App\Services\ClubService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClubTest extends TestCase
{
    public function test_cant_check_in_twice_a_day_in_same_club()
    {
        $club_repo = new ClubRepository(new Club());
        $membership_repo = new MembershipRepository(new Membership());
        $invoice_repo = new InvoiceRepository(new Invoice());
        $checkin_repo = new CheckinRepository(new Checkin());
        $club_service = new ClubService($club_repo, $membership_repo, $invoice_repo, $checkin_repo);

        $user = User::factory()->create();
        $club = Club::factory()->create();

        $club_service->checkIn($club->id, $user);
        $second_time_result = $club_service->checkIn($club->id, $user);

        $this->assertFalse($second_time_result['result']);
    }

    public function test_cant_check_in_twice_a_day_in_same_club()
    {
        $club_repo = new ClubRepository(new Club());
        $membership_repo = new MembershipRepository(new Membership());
        $invoice_repo = new InvoiceRepository(new Invoice());
        $checkin_repo = new CheckinRepository(new Checkin());
        $club_service = new ClubService($club_repo, $membership_repo, $invoice_repo, $checkin_repo);

        $user = User::factory()->create();
        $club = Club::factory()->create();

        $club_service->checkIn($club->id, $user);
        $second_time_result = $club_service->checkIn($club->id, $user);

        $this->assertFalse($second_time_result['result']);
    }


}
