<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            "email_verified_at" => Carbon::now(),
        ]);

        User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            "email_verified_at" => Carbon::now(),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            "email_verified_at" => Carbon::now(),
        ]);

        User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            "email_verified_at" => Carbon::now(),
        ]);
    }
}
