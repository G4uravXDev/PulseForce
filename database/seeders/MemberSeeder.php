<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Manager User
        if (User::where('email', 'admin@pulseforce.com')->count() == 0) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@pulseforce.com',
                'password' => Hash::make('password123'),
                'role' => 'manager',
            ]);
        }

        // Customer Users
        $customers = [
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul.s@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'plan' => 'Pro / Performance',
                'plan_price' => 2499,
                'status' => 'Active',
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya.p@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'plan' => 'Starter / Basic',
                'plan_price' => 999,
                'status' => 'Active',
                'created_at' => now()->subDays(4),
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram.s@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'plan' => 'Elite / Unlimited',
                'plan_price' => 4999,
                'status' => 'Pending',
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Neha Gupta',
                'email' => 'neha.g@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'plan' => 'Pro / Performance',
                'plan_price' => 2499,
                'status' => 'Active',
                'created_at' => now()->subDays(10),
            ],
            [
                'name' => 'Amit Kumar',
                'email' => 'amit.k@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'plan' => 'Starter / Basic',
                'plan_price' => 999,
                'status' => 'Active',
                'created_at' => now()->subDays(15),
            ]
        ];

        foreach ($customers as $customer) {
            if (User::where('email', $customer['email'])->count() == 0) {
                User::create($customer);
            }
        }
    }
}
