<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (! Schema::hasColumn('coupons', 'required_completed_orders')) {
                $table->unsignedInteger('required_completed_orders')->nullable()->after('per_user_limit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'required_completed_orders')) {
                $table->dropColumn('required_completed_orders');
            }
        });
    }
};
