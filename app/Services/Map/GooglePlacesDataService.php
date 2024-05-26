<?php

namespace App\Services\Map;

use App\Data\Map\MapLocationData;
use App\Exceptions\Map\DataFormattingException;

class GooglePlacesDataService
{
    /**
     * Returns formatted data based/throws error on google places response
     *
     * @param string $apiData External data
     * @return array Formatted data
     * @throws DataFormattingException
     * @throws \Exception
     */
    public function getGooglePlacesFormattedData(string $apiData): array
    {
        $data = json_decode($apiData, true);

        if ($data === null) {
            throw new DataFormattingException(message: 'Invalid JSON data.');
        }

        if ($data['status'] === 'OK') {
            return ['data' => $this->formatResult(results: $data['results'])];
        }

        switch ($data['status']) {
            case 'NOT_FOUND':
            case 'ZERO_RESULTS':
                return ['warning' => 'No results found for the requested area.', 'data' => []];
            case 'INVALID_REQUEST':
            case 'OVER_QUERY_LIMIT':
            case 'UNKNOWN_ERROR':
                throw new DataFormattingException(message: 'Error: ' . $data['status']);
            case 'REQUEST_DENIED':
                throw new DataFormattingException(message: 'Error accessing required data. Please, try again later.');
            default:
                throw new DataFormattingException(message: 'Unknown error. Please, try again later.');
        }
    }

    /**
     * Formats external data by building photo url and location object
     *
     * @param array $results External array data
     * @return array Formatted data
     * @throws \Exception
     */
    private function formatResult(array $results): array
    {
        return array_map(function ($result) {
            return MapLocationData::from($result);
        }, $results);
    }
}
