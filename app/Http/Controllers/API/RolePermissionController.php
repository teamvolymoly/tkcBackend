<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class RolePermissionController extends Controller
{
    private function ensureAdmin(Request $request): ?JsonResponse
    {
        if (!$request->user() || !$request->user()->hasRole('admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Only admin users can manage roles and permissions',
            ], 403);
        }

        return null;
    }

    // Create Role
    public function createRole(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) {
            return $response;
        }

        $guardName = config('auth.defaults.guard', 'web');

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('roles', 'name')->where(function ($query) use ($guardName) {
                    return $query->where('guard_name', $guardName);
                }),
            ],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $guardName,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully',
            'role' => $role,
        ], 201);
    }

    // Create Permission
    public function createPermission(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) {
            return $response;
        }

        $guardName = config('auth.defaults.guard', 'web');

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('permissions', 'name')->where(function ($query) use ($guardName) {
                    return $query->where('guard_name', $guardName);
                }),
            ],
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => $guardName,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Permission created successfully',
            'permission' => $permission,
        ], 201);
    }

    // Assign Permission to Role
    public function assignPermission(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) {
            return $response;
        }

        $request->validate([
            'role' => 'required|string',
            'permission' => 'required|string',
        ]);

        $guardName = config('auth.defaults.guard', 'web');

        $role = Role::where('name', $request->role)
            ->where('guard_name', $guardName)
            ->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found',
            ], 404);
        }

        $permission = Permission::where('name', $request->permission)
            ->where('guard_name', $guardName)
            ->first();

        if (!$permission) {
            return response()->json([
                'status' => false,
                'message' => 'Permission not found',
            ], 404);
        }

        $role->givePermissionTo($permission);

        return response()->json([
            'status' => true,
            'message' => 'Permission assigned to role',
        ]);
    }

    // Assign Role to User
    public function assignRole(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) {
            return $response;
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'role' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        $guardName = config('auth.defaults.guard', 'web');

        $role = Role::where('name', $request->role)
            ->where('guard_name', $guardName)
            ->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found',
            ], 404);
        }

        $user->assignRole($role);

        return response()->json([
            'status' => true,
            'message' => 'Role assigned to user',
        ]);
    }

}
