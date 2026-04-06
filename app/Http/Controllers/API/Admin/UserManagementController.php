<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function store(Request $request)
    {
        $guardName = config('auth.defaults.guard', 'web');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')->where(fn ($query) => $query->where('guard_name', $guardName))],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $user->syncRoles([$validated['role']]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user->load('roles'),
        ], 201);
    }

    public function index(Request $request)
    {
        $users = User::with('roles')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($inner) use ($request) {
                    $inner->where('name', 'like', '%'.$request->q.'%')
                        ->orWhere('email', 'like', '%'.$request->q.'%')
                        ->orWhere('phone', 'like', '%'.$request->q.'%');
                });
            })
            ->when($request->filled('role'), function ($query) use ($request) {
                $query->role($request->role);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'data' => $users,
        ]);
    }

    public function show(User $user)
    {
        $user->load([
            'roles',
            'addresses',
            'orders' => fn ($query) => $query->latest()->take(10),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User fetched successfully',
            'data' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $guardName = config('auth.defaults.guard', 'web');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')->where(fn ($query) => $query->where('guard_name', $guardName))],
        ]);

        $targetRole = Role::findByName($validated['role'], $guardName);

        if ($request->user()->is($user) && ! ($targetRole->name === 'admin' || $targetRole->hasPermissionTo('admin.access'))) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot remove your own admin panel access.',
            ], 422);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $user->syncRoles([$validated['role']]);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user->fresh()->load('roles'),
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        if ($user->hasRole('admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Admin accounts cannot be deleted from this panel.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
