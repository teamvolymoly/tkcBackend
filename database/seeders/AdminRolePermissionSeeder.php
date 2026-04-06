<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Services\AdminPermissionRegistry;
use Illuminate\Database\Seeder;

class AdminRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guardName = config('auth.defaults.guard', 'web');

        foreach (AdminPermissionRegistry::permissionNames() as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => $guardName,
            ]);
        }

        foreach (AdminPermissionRegistry::defaultRolePermissions() as $roleName => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guardName,
            ]);

            $role->syncPermissions($permissions);
        }
    }
}
