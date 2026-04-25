<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        $columns = array_values(array_filter([
            Schema::hasColumn('orders', 'cancel_reason') ? 'cancel_reason' : null,
            Schema::hasColumn('orders', 'return_reason') ? 'return_reason' : null,
            Schema::hasColumn('orders', 'return_items') ? 'return_items' : null,
            Schema::hasColumn('orders', 'return_requested_at') ? 'return_requested_at' : null,
        ]));

        if ($columns === []) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
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
        });
    }
};
