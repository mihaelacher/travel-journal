<?php

namespace App\Services\Utils;

use Purifier;

class SecurityUtil
{
    /**
     * @param mixed $input
     * @return mixed
     */
    public static function clean(mixed &$input): mixed
    {
        $output = $input;

        if (is_array($output)) {
            foreach ($output as &$item) {
                $item = self::clean($item);
            }
        } elseif (is_string($output)) {
            if (StrUtil::isJson(string: $output)) {
                $output = json_decode($output, true);
                self::clean(input: $output);
                return $output;
            }
            $output = self::removeScripts(input: $output);
        }

        return $output;
    }

    /**
     * sanitizing string https://github.com/mewebstudio/Purifier
     *
     * @param string $input
     * @return mixed
     */
    public static function removeScripts(string $input): mixed
    {
        return StrUtil::trimSpaces(strip_tags($input) ?? '');
    }
}
