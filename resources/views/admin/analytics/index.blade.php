@extends('admin.layouts.app')

@section('title', 'Analytics')

@php
    $summary = $analytics['summary'] ?? [];
    $overview = $analytics['overview'] ?? ['labels' => [], 'series' => [], 'totals' => []];
    $adminFirstName = trim(explode(' ', $adminUser['name'] ?? 'Ajay')[0] ?? 'Ajay');
    $availableYears = $analytics['filters']['available_years'] ?? [$filters['year'] ?? now()->year];
    $range = $filters['range'] ?? 'yearly';
    $year = $filters['year'] ?? now()->year;
    $cards = [
        ['label' => 'Total Revenue', 'value' => '&#8377; '.number_format((float) ($summary['total_revenue'] ?? 0), 2)],
        ['label' => 'Orders Completed', 'value' => number_format((int) ($summary['orders_completed'] ?? 0))],
        ['label' => 'Total Customers', 'value' => number_format((int) ($summary['total_customers'] ?? 0))],
        ['label' => 'Total Active Products', 'value' => number_format((int) ($summary['total_active_products'] ?? 0))],
    ];
    $cancellations = $analytics['cancellations']['items'] ?? [];
    $topProducts = $analytics['top_selling_products']['items'] ?? [];
    $customers = $analytics['customers']['items'] ?? [];
    $contactQueries = $analytics['contact_queries']['items'] ?? [];
@endphp

@section('content')
<div class="flex h-full flex-col gap-4">
    <section class="rounded-[12px] px-3 py-1 text-[#1d241d]">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-[22px] font-normal tracking-[-0.03em] text-[#1e2620] md:text-[40px]">Good morning, {{ $adminFirstName }}!</h1>
                <p class="mt-1 text-[14px] text-[#52604f]">Track and analyze your mostly online store's performance with detailed breakdown.</p>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-white px-3 py-2 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-[#4cc58a]"></span>
                <span class="text-xs font-medium text-[#556053]">Live analytics</span>
            </div>
        </div>
    </section>

    <section class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as $card)
            <div class="rounded-[8px] bg-white p-4 shadow-sm">
                <p class="text-[12px] text-[#889084]">{{ $card['label'] }}</p>
                <p class="mt-2 text-[28px] font-semibold leading-none text-[#2b322c] md:text-[32px]">{!! $card['value'] !!}</p>
            </div>
        @endforeach
    </section>

    <section class="rounded-[10px] bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-[#edf0ea] pb-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-[#2b322c]">Overview</h2>
                <div class="mt-3 flex flex-wrap gap-5 text-sm text-[#6b7368]">
                    <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-[#72d3e4]"></span>Sales <strong class="text-[#4e5650]">&#8377;{{ number_format((float) ($overview['totals']['sales'] ?? 0), 0) }}</strong></span>
                    <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-[#b6b8bd]"></span>Cancelled <strong class="text-[#4e5650]">&#8377;{{ number_format((float) ($overview['totals']['cancelled'] ?? 0), 0) }}</strong></span>
                    <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-[#3553a6]"></span>Completed <strong class="text-[#4e5650]">{{ number_format((float) ($overview['totals']['completed'] ?? 0), 0) }}</strong></span>
                    <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-[#33c26c]"></span>New Orders <strong class="text-[#4e5650]">{{ number_format((float) ($overview['totals']['new_orders'] ?? 0), 0) }}</strong></span>
                </div>
            </div>

            <form method="GET" class="flex flex-wrap items-center gap-2">
                <select name="year" class="min-w-[100px] rounded-full border border-[#e3e8e0] bg-[#f8faf7] px-4 py-2 text-sm text-[#4f584d]">
                    @foreach ($availableYears as $yearOption)
                        <option value="{{ $yearOption }}" @selected((int) $year === (int) $yearOption)>{{ $yearOption }}</option>
                    @endforeach
                </select>
                <select name="range" class="min-w-[110px] rounded-full border border-[#e3e8e0] bg-[#f8faf7] px-4 py-2 text-sm text-[#4f584d]">
                    <option value="yearly" @selected($range === 'yearly')>Yearly</option>
                </select>
                <button type="submit" class="rounded-full bg-[#708271] px-4 py-2 text-sm font-semibold text-white">Apply</button>
            </form>
        </div>

        <div class="mt-4 h-[310px]">
            <canvas
                id="analytics-overview-chart"
                data-labels='@json($overview["labels"] ?? [])'
                data-sales='@json($overview["series"]["sales"] ?? [])'
                data-cancelled='@json($overview["series"]["cancelled"] ?? [])'
                data-completed='@json($overview["series"]["completed"] ?? [])'
                data-new-orders='@json($overview["series"]["new_orders"] ?? [])'
            ></canvas>
        </div>
    </section>

    <section class="grid gap-3 xl:grid-cols-2">
        <div class="rounded-[8px] bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[15px] font-semibold text-[#2b322c]">Cancellations</h2>
                    <p class="mt-1 text-[11px] text-[#8b9388]">Latest cancelled orders in the selected filter window</p>
                </div>
                <span class="rounded-full bg-[#f1f3ef] px-3 py-1 text-xs font-medium text-[#5b6459]">{{ $analytics['cancellations']['total'] ?? 0 }}</span>
            </div>
            <div class="mt-4 space-y-3">
                @forelse ($cancellations as $item)
                    <div class="rounded-[8px] border border-[#edf0ea] bg-[#fbfcfa] p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-[#2d342e]">{{ $item['order_number'] }}</p>
                                <p class="text-xs text-[#7d8579]">{{ $item['customer_name'] ?: 'Unknown customer' }}</p>
                            </div>
                            <p class="text-sm font-semibold text-[#8d4c4c]">&#8377;{{ number_format((float) $item['total_amount'], 2) }}</p>
                        </div>
                        <p class="mt-2 text-xs text-[#9aa298]">{{ \Illuminate\Support\Carbon::parse($item['created_at'])->format('d M Y, h:i A') }}</p>
                    </div>
                @empty
                    @include('admin.components.empty-state', ['title' => 'No cancellations found', 'message' => 'Cancelled orders in the selected year will appear here.'])
                @endforelse
            </div>
        </div>

        <div class="rounded-[8px] bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[15px] font-semibold text-[#2b322c]">Top Selling Products</h2>
                    <p class="mt-1 text-[11px] text-[#8b9388]">Best performers for the current filter</p>
                </div>
            </div>
            <div class="mt-4 space-y-3">
                @forelse ($topProducts as $index => $item)
                    <div class="flex items-center justify-between rounded-[8px] border border-[#edf0ea] bg-[#fbfcfa] p-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#eef3ec] text-sm font-semibold text-[#5d6b5f]">{{ $index + 1 }}</span>
                            <div>
                                <p class="text-sm font-semibold text-[#2d342e]">{{ $item['name'] }}</p>
                                <p class="text-xs text-[#7d8579]">{{ $item['total_quantity'] }} units sold</p>
                            </div>
                        </div>
                        <p class="text-sm font-semibold text-[#2f6750]">&#8377;{{ number_format((float) $item['total_sales'], 2) }}</p>
                    </div>
                @empty
                    @include('admin.components.empty-state', ['title' => 'No sales data yet', 'message' => 'Top-selling products will appear here once valid orders are available.'])
                @endforelse
            </div>
        </div>
    </section>

    <section class="grid gap-3 xl:grid-cols-2">
        <div class="rounded-[8px] bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[15px] font-semibold text-[#2b322c]">Customers</h2>
                    <p class="mt-1 text-[11px] text-[#8b9388]">New customers in {{ $year }}</p>
                </div>
                <span class="rounded-full bg-[#f1f3ef] px-3 py-1 text-xs font-medium text-[#5b6459]">{{ $analytics['customers']['total'] ?? 0 }}</span>
            </div>
            <div class="mt-4 space-y-3">
                @forelse ($customers as $item)
                    <div class="rounded-[8px] border border-[#edf0ea] bg-[#fbfcfa] p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-[#2d342e]">{{ $item['name'] }}</p>
                                <p class="text-xs text-[#7d8579]">{{ $item['email'] }}</p>
                            </div>
                            <p class="text-xs text-[#8f988d]">{{ \Illuminate\Support\Carbon::parse($item['created_at'])->format('d M Y') }}</p>
                        </div>
                        <p class="mt-2 text-xs text-[#9aa298]">{{ $item['phone'] ?: 'Phone not provided' }}</p>
                    </div>
                @empty
                    @include('admin.components.empty-state', ['title' => 'No new customers found', 'message' => 'New customer signups for the selected filter will show here.'])
                @endforelse
            </div>
        </div>

        <div class="rounded-[8px] bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[15px] font-semibold text-[#2b322c]">Contact us form queries</h2>
                    <p class="mt-1 text-[11px] text-[#8b9388]">Latest messages from the contact form</p>
                </div>
                <span class="rounded-full bg-[#f1f3ef] px-3 py-1 text-xs font-medium text-[#5b6459]">{{ $analytics['contact_queries']['total'] ?? 0 }}</span>
            </div>
            <div class="mt-4 space-y-3">
                @forelse ($contactQueries as $item)
                    <div class="rounded-[8px] border border-[#edf0ea] bg-[#fbfcfa] p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-[#2d342e]">{{ $item['name'] }}</p>
                                <p class="text-xs text-[#7d8579]">{{ $item['email'] }}</p>
                            </div>
                            <p class="text-xs text-[#8f988d]">{{ \Illuminate\Support\Carbon::parse($item['created_at'])->format('d M Y') }}</p>
                        </div>
                        <p class="mt-2 text-xs font-medium text-[#657062]">{{ $item['subject'] ?: 'General inquiry' }}</p>
                        <p class="mt-1 line-clamp-2 text-xs text-[#9aa298]">{{ $item['message'] }}</p>
                    </div>
                @empty
                    @include('admin.components.empty-state', ['title' => 'No contact queries yet', 'message' => 'Incoming contact form submissions will start appearing here automatically.'])
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        (() => {
            const canvas = document.getElementById('analytics-overview-chart');
            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            const labels = JSON.parse(canvas.dataset.labels || '[]');
            const sales = JSON.parse(canvas.dataset.sales || '[]');
            const cancelled = JSON.parse(canvas.dataset.cancelled || '[]');
            const completed = JSON.parse(canvas.dataset.completed || '[]');
            const newOrders = JSON.parse(canvas.dataset.newOrders || '[]');

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Sales',
                            data: sales,
                            backgroundColor: '#72d3e4',
                            borderRadius: 0,
                            barThickness: 20,
                        },
                        {
                            type: 'bar',
                            label: 'Cancelled',
                            data: cancelled,
                            backgroundColor: '#b6b8bd',
                            borderRadius: 0,
                            barThickness: 20,
                        },
                        {
                            type: 'line',
                            label: 'Completed',
                            data: completed,
                            borderColor: '#3553a6',
                            backgroundColor: '#3553a6',
                            tension: 0.35,
                            borderWidth: 2,
                            pointRadius: 0,
                            yAxisID: 'y1',
                        },
                        {
                            type: 'line',
                            label: 'New Orders',
                            data: newOrders,
                            borderColor: '#33c26c',
                            backgroundColor: '#33c26c',
                            tension: 0.35,
                            borderWidth: 2,
                            pointRadius: 0,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#273126',
                            padding: 10,
                            callbacks: {
                                label(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.parsed.y ?? 0;
                                    return ['Sales', 'Cancelled'].includes(label)
                                        ? `${label}: \u20B9${Number(value).toLocaleString()}`
                                        : `${label}: ${Number(value).toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#edf0ea',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#8b9388',
                                maxRotation: 0,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#edf0ea',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#8b9388',
                                callback(value) {
                                    return `\u20B9${Number(value).toLocaleString()}`;
                                }
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#8b9388',
                            }
                        }
                    }
                }
            });
        })();
    </script>
@endpush





