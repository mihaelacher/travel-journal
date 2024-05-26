<?php

namespace App\Data\Map;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class VisitedLocationData extends Data
{
    public function __construct(
        public int $user_id,
        public string $latitude,
        public string $longitude,
        #[MapInputName('uploaded_files')]
        public ?array $photos,
        public Carbon $visited_at,
        public string $name,
        public ?int $location_id = null
    ) {
    }
}
