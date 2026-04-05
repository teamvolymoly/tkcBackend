<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (! Schema::hasColumn('product_variants', 'is_default')) {
                $table->boolean('is_default')->default(false)->after('brewing_rituals');
            }
        });

        if (! $this->hasIndex('product_variants', 'product_variants_product_id_is_default_index')) {
            Schema::table('product_variants', function (Blueprint $table) {
                $table->index(['product_id', 'is_default']);
            });
        }

        Schema::table('product_variant_images', function (Blueprint $table) {
            if (! Schema::hasColumn('product_variant_images', 'image_path')) {
                $table->string('image_path')->nullable()->after('variant_id');
            }

            if (! Schema::hasColumn('product_variant_images', 'is_primary')) {
                $table->boolean('is_primary')->default(false)->after('image_path');
            }
        });

        if (Schema::hasColumn('product_variant_images', 'image_url') && Schema::hasColumn('product_variant_images', 'image_path')) {
            DB::table('product_variant_images')
                ->whereNull('image_path')
                ->update(['image_path' => DB::raw('image_url')]);
        }

        if (! $this->hasIndex('product_variant_images', 'product_variant_images_variant_id_sort_order_index')) {
            Schema::table('product_variant_images', function (Blueprint $table) {
                $table->index(['variant_id', 'sort_order']);
            });
        }

        if (! $this->hasIndex('product_variant_images', 'product_variant_images_variant_id_is_primary_index')) {
            Schema::table('product_variant_images', function (Blueprint $table) {
                $table->index(['variant_id', 'is_primary']);
            });
        }

        $variantIds = DB::table('product_variant_images')
            ->select('variant_id')
            ->distinct()
            ->pluck('variant_id');

        foreach ($variantIds as $variantId) {
            $hasPrimary = DB::table('product_variant_images')
                ->where('variant_id', $variantId)
                ->where('is_primary', true)
                ->exists();

            if ($hasPrimary) {
                continue;
            }

            $firstImageId = DB::table('product_variant_images')
                ->where('variant_id', $variantId)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->value('id');

            if ($firstImageId) {
                DB::table('product_variant_images')
                    ->where('id', $firstImageId)
                    ->update(['is_primary' => true]);
            }
        }
    }

    public function down(): void
    {
        if ($this->hasIndex('product_variant_images', 'product_variant_images_variant_id_is_primary_index')) {
            Schema::table('product_variant_images', function (Blueprint $table) {
                $table->dropIndex('product_variant_images_variant_id_is_primary_index');
            });
        }

        if ($this->hasIndex('product_variant_images', 'product_variant_images_variant_id_sort_order_index')) {
            Schema::table('product_variant_images', function (Blueprint $table) {
                $table->dropIndex('product_variant_images_variant_id_sort_order_index');
            });
        }

        Schema::table('product_variant_images', function (Blueprint $table) {
            if (Schema::hasColumn('product_variant_images', 'is_primary')) {
                $table->dropColumn('is_primary');
            }

            if (Schema::hasColumn('product_variant_images', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });

        if ($this->hasIndex('product_variants', 'product_variants_product_id_is_default_index')) {
            Schema::table('product_variants', function (Blueprint $table) {
                $table->dropIndex('product_variants_product_id_is_default_index');
            });
        }

        Schema::table('product_variants', function (Blueprint $table) {
            if (Schema::hasColumn('product_variants', 'is_default')) {
                $table->dropColumn('is_default');
            }
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', $table)
            ->where('index_name', $indexName)
            ->exists();
    }
};
