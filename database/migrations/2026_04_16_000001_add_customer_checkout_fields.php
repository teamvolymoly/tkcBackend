<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'delivery_phone')) {
                $table->string('delivery_phone')->nullable()->after('phone');
            }
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            if (! Schema::hasColumn('user_addresses', 'label')) {
                $table->string('label')->nullable()->after('user_id');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'tracking_id')) {
                $table->string('tracking_id')->nullable()->after('payment_status');
            }

            if (! Schema::hasColumn('orders', 'cancel_reason')) {
                $table->text('cancel_reason')->nullable()->after('tracking_id');
            }

            if (! Schema::hasColumn('orders', 'return_reason')) {
                $table->text('return_reason')->nullable()->after('cancel_reason');
            }

            if (! Schema::hasColumn('orders', 'return_items')) {
                $table->json('return_items')->nullable()->after('return_reason');
            }

            if (! Schema::hasColumn('orders', 'return_requested_at')) {
                $table->timestamp('return_requested_at')->nullable()->after('return_items');
            }

            if (! Schema::hasColumn('orders', 'delivery_date')) {
                $table->date('delivery_date')->nullable()->after('return_requested_at');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'currency')) {
                $table->string('currency', 10)->default('INR')->after('amount');
            }

            if (! Schema::hasColumn('payments', 'gateway_order_id')) {
                $table->string('gateway_order_id')->nullable()->unique()->after('transaction_id');
            }

            if (! Schema::hasColumn('payments', 'failure_code')) {
                $table->string('failure_code')->nullable()->after('status');
            }

            if (! Schema::hasColumn('payments', 'failure_reason')) {
                $table->text('failure_reason')->nullable()->after('failure_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            foreach (['failure_reason', 'failure_code', 'gateway_order_id', 'currency'] as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            foreach (['delivery_date', 'return_requested_at', 'return_items', 'return_reason', 'cancel_reason', 'tracking_id'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            if (Schema::hasColumn('user_addresses', 'label')) {
                $table->dropColumn('label');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'delivery_phone')) {
                $table->dropColumn('delivery_phone');
            }
        });
    }
};
