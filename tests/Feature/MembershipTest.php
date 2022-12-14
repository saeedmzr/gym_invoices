<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Membership;
use App\Models\User;
use App\Repositories\Membership\MembershipRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Tests\TestCase;

class MembershipTest extends TestCase
{

    private $memberRepository;

    protected function setUp(): void
    {
        $this->memberRepository = new MembershipRepository(new Membership());
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function test_membership_doesnt_work_if_it_pass_expire_time()
    {

        $user = User::factory()->create();
        $club = Club::factory()->create();
        Membership::factory()->create([
            'user_id' => $user->id,
            'club_id' => $club->id,
            'start_at' => Carbon::now()->subMinutes(20),
            'expire_at' => Carbon::now()->subMinutes(5),
            'status' => 'Active',
        ]);


        $available_membership = $this->memberRepository->getAvailableMembership($club, $user);
        $this->assertFalse($available_membership);
    }

    public function test_membership_doesnt_work_if_it_got_canceled()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();
        Membership::factory()->create([
            'user_id' => $user->id,
            'club_id' => $club->id,
            'start_at' => Carbon::now()->subMinutes(20),
            'expire_at' => Carbon::now()->addMinutes(5),
            'status' => 'Cancelled',
        ]);


        $available_membership = $this->memberRepository->getAvailableMembership($club, $user);
        $this->assertFalse($available_membership);
    }

    public function test_membership_doesnt_work_if_it_doesnt_have_any_credits()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();
        Membership::factory()->create([
            'user_id' => $user->id,
            'club_id' => $club->id,
            'start_at' => Carbon::now()->subMinutes(20),
            'expire_at' => Carbon::now()->addMinutes(5),
            'status' => 'Active',
            'credits' => 0,
        ]);


        $available_membership = $this->memberRepository->getAvailableMembership($club, $user);
        $this->assertFalse($available_membership);
    }

    public function test_membership_work()
    {
        $user = User::factory()->create();
        $club = Club::factory()->create();
        Membership::factory()->create([
            'user_id' => $user->id,
            'club_id' => $club->id,
            'start_at' => Carbon::now()->subMinutes(20),
            'expire_at' => Carbon::now()->addMinutes(5),
            'status' => 'Active',
            'credits' => 20,
        ]);


        $available_membership = $this->memberRepository->getAvailableMembership($club, $user);

        $this->assertModelExists($available_membership);
    }

}
