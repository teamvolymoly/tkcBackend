<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_queries', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('id');
            $table->string('phone_number', 50)->nullable()->after('email');
            $table->text('comment')->nullable()->after('phone_number');
        });

        DB::table('contact_queries')->update([
            'company_name' => DB::raw('subject'),
            'phone_number' => DB::raw('phone'),
            'comment' => DB::raw('message'),
        ]);
    }

    public function down(): void
    {
        Schema::table('contact_queries', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'phone_number', 'comment']);
        });
    }
};
