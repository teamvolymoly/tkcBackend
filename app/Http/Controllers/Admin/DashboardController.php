<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController extends BaseAdminController
{
    public function __invoke(): View
    {
        $dashboard = $this->apiService->get('admin/dashboard');

        return view('admin.dashboard.index', [
            'stats' => $dashboard['data'] ?? [],
        ]);
    }
}
