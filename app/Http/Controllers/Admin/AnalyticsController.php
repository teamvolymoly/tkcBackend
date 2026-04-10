<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends BaseAdminController
{
    public function __invoke(Request $request): View
    {
        $filters = [
            'year' => (int) ($request->integer('year') ?: now()->year),
            'range' => $request->string('range')->lower()->value() ?: 'yearly',
        ];

        $response = $this->apiService->get('admin/analytics', $filters);

        return view('admin.analytics.index', [
            'analytics' => $response['data'] ?? [],
            'filters' => $filters,
        ]);
    }
}
