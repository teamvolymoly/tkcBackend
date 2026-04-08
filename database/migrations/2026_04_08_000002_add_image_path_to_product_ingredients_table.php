<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_ingredients', function (Blueprint $table) {
            if (! Schema::hasColumn('product_ingredients', 'image_path')) {
                $table->string('image_path')->nullable()->after('value');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_ingredients', function (Blueprint $table) {
            if (Schema::hasColumn('product_ingredients', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
};
