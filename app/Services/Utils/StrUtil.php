<?php

namespace App\Services\Utils;

class StrUtil
{
    /**
     * trims all whitespaces from a string
     *
     * @param $text
     * @return string
     */
    public static function trimSpaces($text): string
    {
        $text = preg_replace('/[\t\n\r\0\x0B]/', ' ', $text);
        $text = preg_replace('/([\s])\1+/', ' ', $text);

        return trim($text);
    }

    /**
     * Checks if string is a json
     *
     * @param string $string
     * @return bool
     */
    public static function isJson(string $string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Formats input text by converting pascal case to words
     *
     * @param string $value
     * @param bool $capitalizeFirstLetter
     * @return string
     */
    public static function formatInputText(string $value, bool $capitalizeFirstLetter = false): string
    {
        $text = $capitalizeFirstLetter ? ucfirst($value) : $value;
        $words = explode('_', $text);

        return implode(' ', $words);
    }
}
