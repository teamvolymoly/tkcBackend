<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('reviews')) {
            return;
        }

        try {
            DB::statement('ALTER TABLE reviews DROP INDEX reviews_order_item_id_unique');
        } catch (\Throwable) {
        }

        try {
            DB::statement("ALTER TABLE reviews MODIFY status VARCHAR(20) NOT NULL DEFAULT 'pending'");
        } catch (\Throwable) {
        }

        DB::table('reviews')
            ->whereNull('status')
            ->orWhere('status', '')
            ->update(['status' => 'pending']);

        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'order_item_id']);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('reviews')) {
            return;
        }

        try {
            DB::statement('ALTER TABLE reviews DROP INDEX reviews_user_id_order_item_id_unique');
        } catch (\Throwable) {
        }

        try {
            DB::statement("ALTER TABLE reviews MODIFY status VARCHAR(20) NOT NULL DEFAULT 'approved'");
        } catch (\Throwable) {
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['order_item_id']);
        });
    }
};
