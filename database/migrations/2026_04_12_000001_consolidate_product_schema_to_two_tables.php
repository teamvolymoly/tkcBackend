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
            if (! Schema::hasColumn('products', 'tag_line_1')) {
                $table->string('tag_line_1')->nullable()->after('subcategory_id');
            }

            if (! Schema::hasColumn('products', 'tag_line_2')) {
                $table->string('tag_line_2')->nullable()->after('slug');
            }

            foreach (range(1, 5) as $index) {
                $column = 'image_'.$index;

                if (! Schema::hasColumn('products', $column)) {
                    $table->string($column)->nullable()->after($index === 1 ? 'description' : 'image_'.($index - 1));
                }
            }

            if (! Schema::hasColumn('products', 'faqs')) {
                $table->json('faqs')->nullable()->after('ingredients');
            }
        });

        if (Schema::hasTable('product_variant_images')) {
            $products = DB::table('products')->select('id')->get();

            foreach ($products as $product) {
                $paths = DB::table('product_variant_images')
                    ->join('product_variants', 'product_variants.id', '=', 'product_variant_images.variant_id')
                    ->where('product_variants.product_id', $product->id)
                    ->orderByDesc('product_variant_images.is_primary')
                    ->orderBy('product_variant_images.sort_order')
                    ->orderBy('product_variant_images.id')
                    ->limit(5)
                    ->pluck('product_variant_images.image_path')
                    ->values();

                $update = [];
                foreach (range(1, 5) as $index) {
                    $update['image_'.$index] = $paths[$index - 1] ?? null;
                }

                if ($update !== []) {
                    DB::table('products')->where('id', $product->id)->update($update);
                }
            }
        }

        if (Schema::hasTable('product_ingredients')) {
            $products = DB::table('products')->select('id')->get();

            foreach ($products as $product) {
                $ingredients = DB::table('product_ingredients')
                    ->where('product_id', $product->id)
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get(['name', 'image_path'])
                    ->map(fn ($row) => [
                        'name' => $row->name,
                        'image' => $row->image_path,
                    ])
                    ->values()
                    ->all();

                DB::table('products')->where('id', $product->id)->update([
                    'ingredients' => $ingredients !== [] ? json_encode($ingredients, JSON_UNESCAPED_SLASHES) : null,
                ]);
            }
        }

        if (Schema::hasTable('product_variants')) {
            if (Schema::hasColumn('product_variants', 'variant_name') && ! Schema::hasColumn('product_variants', 'name')) {
                DB::statement('ALTER TABLE product_variants CHANGE variant_name name VARCHAR(255) NOT NULL');
            }

            Schema::table('product_variants', function (Blueprint $table) {
                if (Schema::hasColumn('product_variants', 'compare_price') && ! Schema::hasColumn('product_variants', 'discount_price')) {
                    $table->renameColumn('compare_price', 'discount_price');
                }
            });

            Schema::table('product_variants', function (Blueprint $table) {
                if (! Schema::hasColumn('product_variants', 'discount_price')) {
                    $table->decimal('discount_price', 10, 2)->nullable()->after('price');
                }

                if (! Schema::hasColumn('product_variants', 'is_default')) {
                    $table->boolean('is_default')->default(false)->after('brewing_rituals');
                }
            });

            if (Schema::hasColumn('product_variants', 'weight')) {
                DB::statement('ALTER TABLE product_variants MODIFY weight VARCHAR(255) NULL');
            }

            foreach (['stock', 'size', 'color', 'dimensions', 'net_weight', 'tags'] as $column) {
                if (Schema::hasColumn('product_variants', $column)) {
                    Schema::table('product_variants', function (Blueprint $table) use ($column) {
                        $table->dropColumn($column);
                    });
                }
            }
        }

        foreach (['product_variant_images', 'product_images', 'product_ingredients', 'product_nutritions', 'inventories'] as $tableName) {
            Schema::dropIfExists($tableName);
        }
    }

    public function down(): void
    {
        //
    }
};
