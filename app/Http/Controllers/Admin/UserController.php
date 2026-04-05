<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'role', 'page']);

        return view('admin.users.index', [
            'users' => $this->apiService->get('users', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function show(int $user): View
    {
        $response = $this->apiService->get("users/{$user}");
        abort_unless($response['ok'], 404);

        return view('admin.users.show', [
            'user' => $response['data'],
        ]);
    }

    public function edit(int $user): View
    {
        $response = $this->apiService->get("users/{$user}");
        abort_unless($response['ok'], 404);

        return view('admin.users.edit', [
            'user' => $response['data'],
        ]);
    }

    public function update(Request $request, int $user): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:admin,customer'],
        ]);

        $response = $this->apiService->put("users/{$user}", $payload);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update user.');
        }

        return redirect()->route('admin.users.show', $user)->with('success', $response['message'] ?: 'User updated successfully.');
    }

    public function destroy(int $user): RedirectResponse
    {
        $response = $this->apiService->delete("users/{$user}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete user.');
        }

        return redirect()->route('admin.users.index')->with('success', $response['message'] ?: 'User deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer'],
        ]);

        $failures = collect($payload['ids'])->map(function ($id) {
            $response = $this->apiService->delete("users/{$id}");

            return $response['ok'] ? null : ($response['message'] ?: "User {$id} failed");
        })->filter()->values();

        if ($failures->isNotEmpty()) {
            return back()->with('error', 'Some users could not be deleted: '.$failures->implode(', '));
        }

        return redirect()->route('admin.users.index')->with('success', 'Selected users deleted successfully.');
    }
}
