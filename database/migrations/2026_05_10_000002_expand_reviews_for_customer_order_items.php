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

        Schema::table('reviews', function (Blueprint $table) {
            if (! Schema::hasColumn('reviews', 'order_id')) {
                $table->foreignId('order_id')->nullable()->after('user_id')->constrained('orders')->nullOnDelete();
            }

            if (! Schema::hasColumn('reviews', 'order_item_id')) {
                $table->foreignId('order_item_id')->nullable()->after('order_id')->constrained('order_items')->nullOnDelete();
            }

            if (! Schema::hasColumn('reviews', 'variant_id')) {
                $table->foreignId('variant_id')->nullable()->after('product_id')->constrained('product_variants')->nullOnDelete();
            }

            if (! Schema::hasColumn('reviews', 'title')) {
                $table->string('title')->nullable()->after('rating');
            }

            if (! Schema::hasColumn('reviews', 'status')) {
                $table->string('status', 20)->default('approved')->after('review');
            }
        });

        try {
            DB::statement('ALTER TABLE reviews DROP INDEX reviews_product_id_user_id_unique');
        } catch (\Throwable) {
            // Ignore if the legacy unique index is already missing.
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['order_item_id']);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('reviews')) {
            return;
        }

        Schema::table('reviews', function (Blueprint $table) {
            try {
                $table->dropUnique(['order_item_id']);
            } catch (\Throwable) {
            }

            foreach (['variant_id', 'order_item_id', 'order_id'] as $foreignColumn) {
                try {
                    $table->dropForeign([$foreignColumn]);
                } catch (\Throwable) {
                }
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            foreach (['status', 'title', 'variant_id', 'order_item_id', 'order_id'] as $column) {
                if (Schema::hasColumn('reviews', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['product_id', 'user_id']);
        });
    }
};
