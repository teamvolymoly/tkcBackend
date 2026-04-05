<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (! Schema::hasColumn('product_variants', 'size')) {
                $table->string('size')->nullable()->after('variant_name');
            }

            if (! Schema::hasColumn('product_variants', 'color')) {
                $table->string('color')->nullable()->after('size');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (Schema::hasColumn('product_variants', 'color')) {
                $table->dropColumn('color');
            }

            if (Schema::hasColumn('product_variants', 'size')) {
                $table->dropColumn('size');
            }
        });
    }
};
