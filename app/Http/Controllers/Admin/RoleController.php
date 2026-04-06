<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'page']);
        $response = $this->apiService->get('roles', array_filter($filters, fn ($value) => $value !== null && $value !== ''));

        return view('admin.roles.index', [
            'roles' => $response['data'] ?? [],
            'filters' => $filters,
            'permissionGroups' => data_get($response, 'raw.meta.permission_groups', []),
            'protectedRoles' => data_get($response, 'raw.meta.protected_roles', []),
        ]);
    }

    public function edit(int $role): View
    {
        $response = $this->apiService->get("roles/{$role}");
        abort_unless($response['ok'], 404);

        return view('admin.roles.edit', [
            'role' => $response['data'],
            'permissionGroups' => data_get($response, 'raw.meta.permission_groups', []),
            'protectedRoles' => data_get($response, 'raw.meta.protected_roles', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $response = $this->apiService->post('roles', $payload);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to create role.');
        }

        return redirect()->route('admin.roles.index')->with('success', $response['message'] ?: 'Role created successfully.');
    }

    public function update(Request $request, int $role): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $response = $this->apiService->put("roles/{$role}", $payload);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update role.');
        }

        return redirect()->route('admin.roles.edit', $role)->with('success', $response['message'] ?: 'Role updated successfully.');
    }

    public function destroy(int $role): RedirectResponse
    {
        $response = $this->apiService->delete("roles/{$role}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete role.');
        }

        return redirect()->route('admin.roles.index')->with('success', $response['message'] ?: 'Role deleted successfully.');
    }
}
