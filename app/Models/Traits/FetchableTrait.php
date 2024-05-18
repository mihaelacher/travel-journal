<?php

namespace App\Models\Traits;

use App\Services\Utils\CacheUtil;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

trait FetchableTrait
{
    private $allStore = null;           // Hold in-memory cache of all db rows.

    private static $instance = null;    // Hold the class instance.

    // The object is created from within the class itself
    // only if the class has no instance.
    private static function getInstance(): ?FetchableTrait
    {
        if (self::$instance == null) {
            $className = static::class;
            self::$instance = new $className;
        }

        return self::$instance;
    }

    /**
     * Fetch all items in current table. Return an associative array of "id" => "name" values.
     */
    public static function fetchAll(string $column = 'name'): ?array
    {
        $items = self::fetchAllFull();

        return $items->pluck($column, 'id')?->toArray();
    }

    /**
     * Fetch all items in current table. Return a full-blown collection with all rows.
     *
     * @return Collection|array|null
     */
    public static function fetchAllFull(): Collection|array|null
    {
        // Check in cache first.
        $key = 'fetchableTrait-fetchAllFull:class-'.static::class;
        $instance = self::getInstance();

        // If not in memory, then check in cache.
        if (! isset($instance->allStore)) {
            $instance->allStore = CacheUtil::sanitizeArrayRead(Cache::get($key));
        }

        // Get from database.
        if (! isset($instance->allStore)) {
            Cache::put($key, $instance->allStore, 60 * 60 * 24 * 30); // Cache for 1 month.
        }

        return $instance->allStore;
    }

    /**
     * @return void
     */
    public static function forgetAllFull(): void
    {
        $key = 'fetchableTrait-fetchAllFull:class-'.static::class;
        Cache::forget($key);
    }
}
