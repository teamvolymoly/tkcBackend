<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Role;
use App\Services\AdminPermissionRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        AdminPermissionRegistry::ensurePermissionsExist();

        $roles = Role::query()
            ->where('guard_name', config('auth.defaults.guard', 'web'))
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->string('q')->trim().'%');
            })
            ->with('permissions:id,name')
            ->withCount(['permissions', 'users'])
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Roles fetched successfully.',
            'data' => $roles,
            'meta' => [
                'permission_groups' => AdminPermissionRegistry::groups(),
                'protected_roles' => AdminPermissionRegistry::protectedRoles(),
            ],
        ]);
    }

    public function options(): JsonResponse
    {
        $roles = Role::query()
            ->where('guard_name', config('auth.defaults.guard', 'web'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'status' => true,
            'message' => 'Role options fetched successfully.',
            'data' => $roles,
        ]);
    }

    public function show(Role $role): JsonResponse
    {
        abort_unless($role->guard_name === config('auth.defaults.guard', 'web'), 404);

        AdminPermissionRegistry::ensurePermissionsExist();

        $role->load('permissions:id,name')->loadCount(['permissions', 'users']);

        return response()->json([
            'status' => true,
            'message' => 'Role fetched successfully.',
            'data' => $role,
            'meta' => [
                'permission_groups' => AdminPermissionRegistry::groups(),
                'protected_roles' => AdminPermissionRegistry::protectedRoles(),
            ],
        ]);
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        AdminPermissionRegistry::ensurePermissionsExist();

        $role = Role::create([
            'name' => strtolower(trim($request->string('name')->value())),
            'guard_name' => config('auth.defaults.guard', 'web'),
        ]);

        $role->syncPermissions($request->validated('permissions', []));
        $role->load('permissions:id,name')->loadCount(['permissions', 'users']);

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully.',
            'data' => $role,
        ], 201);
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        abort_unless($role->guard_name === config('auth.defaults.guard', 'web'), 404);

        AdminPermissionRegistry::ensurePermissionsExist();

        if ($role->isProtected() && $request->string('name')->lower()->value() !== $role->name) {
            return response()->json([
                'status' => false,
                'message' => 'Protected roles cannot be renamed.',
            ], 422);
        }

        $role->update([
            'name' => $role->isProtected() ? $role->name : strtolower(trim($request->string('name')->value())),
        ]);

        $role->syncPermissions($request->validated('permissions', []));
        $role->load('permissions:id,name')->loadCount(['permissions', 'users']);

        return response()->json([
            'status' => true,
            'message' => 'Role updated successfully.',
            'data' => $role,
        ]);
    }

    public function destroy(Role $role): JsonResponse
    {
        abort_unless($role->guard_name === config('auth.defaults.guard', 'web'), 404);

        if ($role->isProtected()) {
            return response()->json([
                'status' => false,
                'message' => 'This role is protected and cannot be deleted.',
            ], 422);
        }

        if ($role->users()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'This role is assigned to users. Reassign them before deleting the role.',
            ], 422);
        }

        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully.',
        ]);
    }
}
