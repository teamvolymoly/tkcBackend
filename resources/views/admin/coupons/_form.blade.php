<div class="space-y-6">
    <section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <div class="border-b border-slate-200/80 px-6 py-5 dark:border-slate-800">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Coupon</p>
                    <h2 class="mt-1 text-xl font-semibold text-slate-900 dark:text-slate-100">Discount Rule</h2>
                </div>
                <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-200">
                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(old('is_active', $coupon['is_active'] ?? true))>
                    <span>Coupon active</span>
                </label>
            </div>
        </div>

        <div class="p-6">
            <div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-4">
                <div class="xl:col-span-2">
                    <label class="mb-2 block text-sm font-medium">Coupon code</label>
                    <input type="text" name="code" value="{{ old('code', $coupon['code'] ?? '') }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="SUMMER20">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Discount type</label>
                    <select name="discount_type" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                        @foreach (['fixed', 'percent'] as $type)
                            <option value="{{ $type }}" @selected(old('discount_type', $coupon['discount_type'] ?? 'fixed') === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Discount value</label>
                    <input type="number" step="0.01" min="0" name="discount_value" value="{{ old('discount_value', $coupon['discount_value'] ?? '') }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="100 or 10">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Apply after completed orders</label>
                    <input type="number" min="1" name="required_completed_orders" value="{{ old('required_completed_orders', $coupon['required_completed_orders'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Optional">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Minimum order amount</label>
                    <input type="number" step="0.01" min="0" name="min_order_amount" value="{{ old('min_order_amount', $coupon['min_order_amount'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Optional">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Maximum discount</label>
                    <input type="number" step="0.01" min="0" name="max_discount" value="{{ old('max_discount', $coupon['max_discount'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Only for percent coupons">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Expiry date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', !empty($coupon['expiry_date']) ? \Illuminate\Support\Carbon::parse($coupon['expiry_date'])->format('Y-m-d') : '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Usage limit</label>
                    <input type="number" min="1" name="usage_limit" value="{{ old('usage_limit', $coupon['usage_limit'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="All users total">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Per-user limit</label>
                    <input type="number" min="1" name="per_user_limit" value="{{ old('per_user_limit', $coupon['per_user_limit'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="One customer total">
                </div>
            </div>
        </div>
    </section>
</div>
