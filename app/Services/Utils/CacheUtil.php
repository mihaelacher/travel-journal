<?php

namespace App\Services\Utils;

use Auth;
use Illuminate\Database\Eloquent\Collection;

class CacheUtil
{
    const NIL = '-nil-';

    const NIL_ARR = '-nilarr-';

    const NIL_COLL = '-nilcoll-';

    /**
     * Sanitize value after reading from KV store.
     * NB: Redis does not store empty values.
     *
     * @param $cache - data that has been read from KV store.
     * @return mixed
     */
    public static function sanitizeArrayRead($cache): mixed
    {
        // Sanity check.
        if (is_null($cache)) {
            return null;
        }

        // In case no sanitization is required.
        if (is_array($cache) || $cache instanceof Collection) {
            return $cache;
        }

        // 1. Workaround: Redis does not store empty values.
        if (in_array($cache, [self::NIL_ARR, self::NIL_COLL])) {
            $cache = self::sanitizeRead(value: $cache);
        }
        // 2. Convert "stdClass" objects into arrays.
        else {
            $cache = json_decode($cache);

            if (is_object($cache) && get_class($cache) === 'stdClass') {
                $cache = json_decode(json_encode($cache), true);
            }
        }

        return $cache;
    }

    /**
     * Sanitize value after reading from KV store.
     * NB: Redis does not store empty values.
     *
     * @param $value - data that has been read from KV store.
     * @return mixed
     */
    public static function sanitizeRead($value): mixed
    {
        if ($value === self::NIL_ARR) {
            $value = [];
        } elseif ($value === self::NIL_COLL) {
            $value = new Collection();
        } elseif ($value === self::NIL) {
            $value = null;
        }

        return $value;
    }
}
