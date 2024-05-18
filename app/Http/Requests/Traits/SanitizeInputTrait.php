<?php

namespace App\Http\Requests\Traits;

use App\Services\Utils\SecurityUtil;

trait SanitizeInputTrait
{
    /**
     * @return array
     */
    protected function sanitizeInput(): array
    {
        $input = $this->all();
        $keys = array_keys($input);
        foreach ($keys as $key) {
            $value = $input[$key];
            $input[$key] = SecurityUtil::clean($value);
        }
        $this->replace($input);
        return $this->all();
    }
}
