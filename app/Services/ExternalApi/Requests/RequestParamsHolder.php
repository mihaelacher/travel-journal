<?php

namespace App\Services\ExternalApi\Requests;

class RequestParamsHolder
{
    /**
     * @param array $searchParams
     */
    public function __construct(private readonly array $searchParams) {}

    /**
     * @return array
     */
    public function getSearchParams(): array
    {
        return $this->searchParams;
    }
}
