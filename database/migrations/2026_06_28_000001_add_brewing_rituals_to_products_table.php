<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'brewing_rituals')) {
                $table->json('brewing_rituals')->nullable()->after('faqs');
            }
        });

        if (Schema::hasColumn('product_variants', 'brewing_rituals')) {
            DB::table('products')
                ->leftJoin('product_variants', function ($join) {
                    $join->on('products.id', '=', 'product_variants.product_id')
                        ->where('product_variants.is_default', true);
                })
                ->whereNull('products.brewing_rituals')
                ->whereNotNull('product_variants.brewing_rituals')
                ->update(['products.brewing_rituals' => DB::raw('product_variants.brewing_rituals')]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'brewing_rituals')) {
                $table->dropColumn('brewing_rituals');
            }
        });
    }
};
