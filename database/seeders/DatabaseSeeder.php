<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Club;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        User::factory()->count(20)->create();
        Club::factory()->count(10)->create();
        Membership::factory()->count(5)->create();
        $this->registerAdmin();
    }

    public function registerAdmin()
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'name' => 'admin',
            'is_admin' => 1
        ]);
    }
}
