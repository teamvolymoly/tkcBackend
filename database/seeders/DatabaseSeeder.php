<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminRolePermissionSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '9999999999',
                'password' => 'password',
            ]
        );
        $admin->syncRoles(['admin']);

        $customer = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '8888888888',
                'password' => 'password',
            ]
        );
        $customer->syncRoles(['customer']);
    }
}
