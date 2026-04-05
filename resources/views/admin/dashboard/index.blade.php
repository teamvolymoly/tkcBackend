@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@php($revenue = (float) ($stats['revenue'] ?? 0))
@php($totalOrders = (int) ($stats['total_orders'] ?? 0))
@php($totalCustomers = (int) ($stats['total_customers'] ?? 0))
@php($pendingOrders = (int) ($stats['pending_orders'] ?? 0))
@php($adminFirstName = trim(explode(' ', $adminUser['name'] ?? 'Ajay')[0] ?? 'Ajay'))
@php($summaryCards = [
    ['label' => 'Earned in March', 'value' => number_format($revenue, 2), 'suffix' => '', 'chip' => '+16.5%', 'note' => 'Sales last month'],
    ['label' => 'Active Orders', 'value' => number_format($totalOrders), 'suffix' => '', 'chip' => '-5.5%', 'note' => 'Since last month'],
    ['label' => 'Total Visitors', 'value' => number_format($totalCustomers), 'suffix' => '', 'chip' => '-2%', 'note' => 'Since last month'],
    ['label' => 'Cancellations in March', 'value' => number_format($pendingOrders), 'suffix' => '', 'chip' => '+3.5%', 'note' => 'Since last month'],
])

<div class="flex h-full flex-col gap-3">
    <section class="rounded-[12px] px-3 py-1 text-[#1d241d]">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-[22px] font-normal tracking-[-0.03em] text-[#1e2620] md:text-[40px]">Good night, {{ $adminFirstName }} !</h1>

                <p class="mt-1 text-[14px] text-[#52604f]">Track and analyze your monthly online store's performance with detailed breakdown.</p>
            </div>
            <button type="button" class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-[#5f675d] shadow-sm">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 17.25h.008v.008H12v-.008zM12 12h.008v.008H12V12zm0-5.25h.008v.008H12V6.75z"/></svg>
            </button>
        </div>
    </section>

    <section class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($summaryCards as $card)
            <div class="rounded-[8px] bg-white p-3 shadow-sm">
                <p class="text-[16px] text-[#657062]">{{ $card['label'] }}</p>
                <div class="mt-2 flex items-end justify-between gap-3">
                    <div>
                        <p class="text-[14px] font-semibold leading-none text-[#2b322c] md:text-[32px]">
                            @if ($card['label'] === 'Earned in March')
                                &#8377; {{ $card['value'] }}
                            @else
                                {{ $card['value'] }}{{ $card['suffix'] }}
                            @endif
                        </p>
                        <div class="mt-4 flex items-start gap-0.5 flex-col">
                            <div class="rounded-full px-1.5 py-0.5 text-[8px] font-medium {{ str_starts_with($card['chip'], '+') ? 'bg-[#e1f2df] text-[#4e9b55]' : 'bg-[#fbe3e2] text-[#d66c67]' }}">{{ $card['chip'] }}</div>
                            <p class="text-[10px] text-[#8c9589]">{{ $card['note'] }}</p>
                        </div>
                    </div>
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-[#eceee9] text-[#91998e]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M9 7h8v8"/></svg>
                    </span>
                </div>
            </div>
        @endforeach
    </section>

    <section class="grid flex-1 gap-3 xl:grid-cols-[1.08fr_0.92fr]">
        <div class="rounded-[8px] bg-white p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-[11px] font-medium text-[#556053]">New Orders</h2>
            </div>
            <div class="mt-2 overflow-hidden rounded-full bg-[#f1f2ef] p-1">
                <div class="flex h-4 items-center justify-center rounded-full bg-[#ececea] text-[7px] text-[#6f766f]">
                    No active orders
                </div>
            </div>
            <div class="mt-3 h-[260px] rounded-[6px] bg-[#fbfbfa]"></div>
        </div>

        <div class="rounded-[8px] bg-white p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-[11px] font-medium text-[#556053]">Stock Overview</h2>
            </div>
            <div class="mt-3 rounded-full bg-[#f1f2ef] p-1">
                <div class="flex h-4 items-center justify-center rounded-full bg-[#ececea] text-[7px] text-[#6f766f]">
                    Low Stock Alerts
                </div>
            </div>
            <div class="mt-3 h-[282px] rounded-[6px] bg-[#fbfbfa]"></div>
        </div>
    </section>
</div>
@endsection
