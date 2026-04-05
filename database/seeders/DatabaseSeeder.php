<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => config('auth.defaults.guard', 'web'),
        ]);

        $customerRole = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => config('auth.defaults.guard', 'web'),
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '9999999999',
                'password' => 'password',
            ]
        );
        $admin->assignRole($adminRole);

        $customer = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '8888888888',
                'password' => 'password',
            ]
        );
        $customer->assignRole($customerRole);
    }
}
