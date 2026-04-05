<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminApiService;
use Illuminate\Http\RedirectResponse;

class BaseAdminController extends Controller
{
    public function __construct(protected readonly AdminApiService $apiService)
    {
    }

    protected function backWithApiError(array $response, string $fallbackMessage): RedirectResponse
    {
        if (! empty($response['errors'])) {
            return back()->withErrors($response['errors'])->withInput();
        }

        return back()->withInput()->with('error', $response['message'] ?: $fallbackMessage);
    }
}
