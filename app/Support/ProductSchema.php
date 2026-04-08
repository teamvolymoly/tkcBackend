<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;

class ProductSchema
{
    private static array $columnCache = [];

    public static function hasColumn(string $table, string $column): bool
    {
        $key = $table.'.'.$column;

        if (! array_key_exists($key, self::$columnCache)) {
            self::$columnCache[$key] = Schema::hasTable($table) && Schema::hasColumn($table, $column);
        }

        return self::$columnCache[$key];
    }
}
