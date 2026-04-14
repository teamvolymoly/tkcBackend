<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'caffeine')) {
                $table->string('caffeine')->nullable()->after('description');
            }

            if (! Schema::hasColumn('products', 'collection')) {
                $table->text('collection')->nullable()->after('caffeine');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'collection')) {
                $table->dropColumn('collection');
            }

            if (Schema::hasColumn('products', 'caffeine')) {
                $table->dropColumn('caffeine');
            }
        });
    }
};
