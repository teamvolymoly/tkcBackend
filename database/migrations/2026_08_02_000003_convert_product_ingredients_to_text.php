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
            $table->text('ingredients')->nullable()->change();
        });

        DB::table('products')->select('id', 'ingredients')->orderBy('id')->each(function ($product) {
            $decoded = json_decode((string) $product->ingredients, true);

            if (! is_array($decoded)) {
                return;
            }

            $ingredients = collect($decoded)
                ->map(fn ($ingredient) => is_array($ingredient) ? ($ingredient['name'] ?? '') : $ingredient)
                ->map(fn ($ingredient) => trim((string) $ingredient))
                ->filter()
                ->implode(', ');

            DB::table('products')->where('id', $product->id)->update([
                'ingredients' => $ingredients ?: null,
            ]);
        });
    }

    public function down(): void
    {
        DB::table('products')->select('id', 'ingredients')->orderBy('id')->each(function ($product) {
            $ingredients = trim((string) $product->ingredients);

            DB::table('products')->where('id', $product->id)->update([
                'ingredients' => $ingredients === '' ? null : json_encode([['name' => $ingredients, 'image' => null]]),
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->json('ingredients')->nullable()->change();
        });
    }
};
