<?php

namespace App\Data\ExternalApi;

use Spatie\LaravelData\Data;

abstract class BaseEndpointData extends Data {

    // ---------------------------------- GETTERS ------------------------------------------ //
    abstract function getPathPattern(): string;
    abstract function getBaseUrl();

    /**
     * @return string
     * @throws \Exception
     */
    public function buildEndpoint(): string
    {
        $path = $this->buildEndpointPath(string: $this->getPathPattern(), replacements: $this->toArray());

        return $this->getBaseUrl() . $path;
    }

    /**
     * @param string $string
     * @param array $replacements
     * @return array|string
     */
    private function buildEndpointPath(string $string, array $replacements): array|string
    {
        return str_replace(
            array_map(
                function ($k) {
                    return sprintf('{%s}', $k);
                },
                array_keys($replacements)
            ),
            array_values($replacements),
            $string
        );
    }
}
