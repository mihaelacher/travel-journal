<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * App\Models\ExternalApiRequest
 *
 * @property int $id
 * @property string $request_body
 * @property string $request_response_code
 * @property string $request_response_body
 * @property string $request_endpoint
 * @property int $created_by
 * @property Carbon $created_at
 *
 */
class ExternalApiRequest extends MainModel
{
    protected $table = 'external_api_requests';
}
