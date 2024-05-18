<?php

namespace App\Services\ExternalApi;

use Symfony\Component\HttpFoundation\Response;

class BaseApiResponse extends Response
{
    private int $requestId;

    public function __construct(int $requestId, ?string $content = '', int $status = 200, array $headers = [])
    {
        $this->setRequestId($requestId);
        parent::__construct($content, $status, $headers);
    }

    /**
     * @return void
     */
    public function getBody(): void
    {
        json_encode($this->getContent(), true);
    }

    public function getRequestId(): int
    {
        return $this->requestId;
    }

    public function setRequestId(int $requestId): void
    {
        $this->requestId = $requestId;
    }
}
