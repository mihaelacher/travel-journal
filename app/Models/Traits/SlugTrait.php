<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait SlugTrait
{
    use FetchableTrait;

    private $idStore = [];

    private $slugStore = [];

    /**
     * Return id by slug.
     *
     * @param $slug string
     */
    public static function slugId($slug): ?int
    {
        // Check in cache first.
        $key = 'slugId:class-'.static::class.':slug-'.$slug;
        $instance = self::getInstance();

        // If not in memory, then check in cache.
        if (! isset($instance->slugStore[$key])) {
            $instance->slugStore[$key] = Cache::get($key);
        }

        // Get from database.
        if (! isset($instance->slugStore[$key])) {
            $items = self::fetchAllFull();
            foreach ($items ?? [] as $item) {
                if ($item->slug == $slug) {
                    $instance->slugStore[$key] = (int) $item->id;
                }
            }
            Cache::put($key, $instance->slugStore[$key], 60 * 60 * 24 * 30); // Cache for 1 month.
        }

        return $instance->slugStore[$key];
    }

    /**
     * Return slug by id.
     *
     * @param $id int
     */
    public static function idSlug($id): ?string
    {
        // Check in MEMORY and CACHE first.
        $key = 'idSlug:class-'.static::class.':id-'.$id;
        $instance = self::getInstance();

        // If not in MEMORY, then check in CACHE.
        if (! isset($instance->idStore[$key])) {
            $instance->idStore[$key] = Cache::get($key);
        }

        // Get from DATABASE.
        if (! isset($instance->idStore[$key])) {
            $items = self::fetchAllFull();
            foreach ($items ?? [] as $item) {
                if ($item->id == $id) {
                    $instance->idStore[$key] = $item->slug;
                }
            }
            Cache::put($key, $instance->idStore[$key], 60 * 60 * 24 * 30); // Cache for 1 month.
        }

        return $instance->idStore[$key];
    }

    /**
     * Return ids by slugArray.
     *
     * @param $arr array
     */
    public static function getSlugIds($arr): array
    {
        foreach ($arr as &$a) {
            $a = self::slugId($a);
        }

        return $arr;
    }
}
