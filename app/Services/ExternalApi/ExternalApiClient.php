<?php

namespace App\Services\ExternalApi;

use App\Data\ExternalApi\BaseEndpointData;
use App\Exceptions\ExternalApi\ExternalApiException;
use App\Models\ExternalApiRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ExternalApiClient implements ApiClientInterface
{
    /** @var string $endpoint */
    private string $endpoint;

    /**
     * @param string $method
     * @param BaseEndpointData $dataObject
     * @throws \Exception
     */
    public function __construct(private readonly string $method, BaseEndpointData $dataObject)
    {
        $this->endpoint = $dataObject->buildEndpoint();
    }

    /**
     * @return BaseApiResponse
     * @throws ExternalApiException
     */
    public function send(): BaseApiResponse
    {
        $externalApiRequest = $this->createExternalApiRequest();
        try {
            $client = new Client();

            $response = $client->request(method: $this->method, uri: $this->endpoint);

            $externalApiRequest->request_response_code = (int)$response->getStatusCode();
            $externalApiRequest->request_response_body = (string)$response->getBody();
            $externalApiRequest->save();
        } catch (Throwable $t) {
            $response = (object)[
                'errors' => [
                    'message'   => $t->getMessage(),
                    'trace'     => $t->getTrace(),
                    'line'      => $t->getLine()
                ]
            ];

            $externalApiRequest->request_response_code = 500;
            $externalApiRequest->request_response_body = json_encode($response);
            $externalApiRequest->save();

            throw new ExternalApiException();
        }

        return $this->createNewResponse($externalApiRequest);
    }

    /**
     * @return ExternalApiRequest
     */
    private function createExternalApiRequest(): ExternalApiRequest
    {
        $externalApiRequest = new ExternalApiRequest();
        $externalApiRequest->request_endpoint = $this->endpoint;
        $externalApiRequest->request_body = '';
        $externalApiRequest->created_by = Auth::id();
        $externalApiRequest->save();

        return $externalApiRequest;
    }

    /**
     * @param ExternalApiRequest $externalApiRequest
     * @return BaseApiResponse
     */
    private function createNewResponse(ExternalApiRequest $externalApiRequest): BaseApiResponse
    {
        return new BaseApiResponse(
            requestId: $externalApiRequest->id,
            content: $externalApiRequest->request_response_body,
            status: $externalApiRequest->request_response_code,
        );
    }
}
