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
use App\Repositories\User\UserRepository;
use App\Services\ClubService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClubTest extends TestCase
{
    protected ClubRepository $clubRepository;
    protected MembershipRepository $membershipRepository;
    protected InvoiceRepository $invoiceRepository;
    protected CheckinRepository $checkinRepository;
    protected ClubService $clubService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clubRepository = new ClubRepository(new Club());
        $this->membershipRepository = new MembershipRepository(new Membership());
        $this->invoiceRepository = new InvoiceRepository(new Invoice());
        $this->checkinRepository = new CheckinRepository(new Checkin());
        $this->clubService = new ClubService($this->clubRepository, $this->membershipRepository, $this->invoiceRepository, $this->checkinRepository);
    }

    public function test_check_in_normally_should_return_status_code_200()
    {


        $user = User::factory()->create();
        $club = Club::factory()->create();

        $check_in = $this->clubService->checkIn($club->id, $user);

        $this->assertTrue($check_in['result']);
    }

    public function test_invoice_get_create_first_time_that_user_check_in_a_club()
    {

        $user = User::factory()->create();
        $club = Club::factory()->create();

        $check_in = $this->clubService->checkIn($club->id, $user);

        $invoice_model = $this->invoiceRepository->findById($check_in['data']->id);

        $this->assertModelExists($invoice_model);
    }

    public function test_if_user_check_in_in_two_different_clubs_then_he_got_two_invoice_records()
    {

        $user = User::factory()->create();
        $club_1 = Club::factory()->create();
        $club_2 = Club::factory()->create();

        $check_in_1 = $this->clubService->checkIn($club_1->id, $user);
        $check_in_2 = $this->clubService->checkIn($club_2->id, $user);

        $invoice_count = $user->invoices()->count();

        $this->assertEquals(2, $invoice_count);
    }

    public function test_if_user_check_in_with_no_credits_of_membership()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();

        $this->membershipRepository->create([
            'club_id' => $club->id,
            'user_id' => $user->id,
            'start_at' => Carbon::now()->subMinutes(5),
            'expire_at' => Carbon::now()->addMinutes(5),
            'credits' => 0,
            'status' => 'Active',
        ]);

        $check = $this->clubService->checkIn($club->id, $user);

        $last_checkin = $this->checkinRepository->getLastCheckIn($user->id);


        $this->assertEquals('Guest', $last_checkin->type);
    }

    public function test_invoice_total_amount_should_return_exactly_what_we_except_for_guest()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create(['cost_per_check_in' => 100]);

        $first_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(3)]);

        $second_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(2)]);

        $third_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(1)]);

        $forth_day_check_in = $this->clubService->checkIn($club->id, $user);


        $this->assertEquals($club->cost_per_check_in * 4, $forth_day_check_in['data']->amount);
    }

    public function test_invoice_total_amount_should_return_exactly_what_we_except_for_membership()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create(['cost_per_check_in' => 100]);

        $this->membershipRepository->create([
            'user_id' => $user->id,
            'club_id' => $club->id,
            'start_at' => Carbon::now()->subMinutes(20),
            'expire_at' => Carbon::now()->addMinutes(5),
            'status' => 'Active',
            'credits' => 4,
        ]);

        $first_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(3)]);

        $second_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(2)]);

        $third_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(1)]);

        $forth_day_check_in = $this->clubService->checkIn($club->id, $user);


        $this->assertEquals($club->cost_per_check_in * 0, $forth_day_check_in['data']->amount);
    }

    public function test_invoice_total_amount_should_return_exactly_what_we_except_for_membership_if_it_ends_between()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();

        $this->membershipRepository->create([
            'user_id' => $user->id,
            'club_id' => $club->id,
            'start_at' => Carbon::now()->subMinutes(20),
            'expire_at' => Carbon::now()->addMinutes(5),
            'status' => 'Active',
            'credits' => 2,
        ]);

        $first_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(3)]);

        $second_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(2)]);

        $third_day_check_in = $this->clubService->checkIn($club->id, $user);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->subdays(1)]);

        $forth_day_check_in = $this->clubService->checkIn($club->id, $user);


        $this->assertEquals($club->cost_per_check_in * 2, $forth_day_check_in['data']->amount);
    }

    public function test_invoice_get_created_again_if_month_passes()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();

        $first_check_in = $this->clubService->checkIn($club->id, $user);
        $first_check_in['data']->update(['created_at' => Carbon::now()->addMonths(2)]);
        $this->checkinRepository->getLastCheckIn($user->id)->update(['created_at' => Carbon::now()->addMonths(2)]);

        $second_check_in = $this->clubService->checkIn($club->id, $user);

        $this->assertEquals(2, $user->invoices()->count());

    }

    public function test_cant_check_in_twice_a_day_in_same_club()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();

        $this->clubService->checkIn($club->id, $user);
        $second_time_result = $this->clubService->checkIn($club->id, $user);

        $this->assertFalse($second_time_result['result']);
    }


}
