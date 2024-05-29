<?php

namespace App\Data\Map;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class LocationModalData extends Data {
    public function __construct(
        public string $name,
        #[MapInputName('location.lat')]
        public float $latitude,
        #[MapInputName('location.lng')]
        public float $longitude,
        #[MapInputName('photo_urls')]
        public array $photoUrls,
        #[MapInputName('location_id')]
        public ?int $locationId,
        #[MapInputName('visited_at')]
        public ?string $visitedAt,
        #[MapInputName('is_shared')]
        public ?int $isShared,
    ) {
    }

    public static function from(mixed ...$payloads): static
    {
        $payload = reset($payloads);
        $payload['visited_at'] = isset($payload['visited_at'])
            ? Carbon::parse($payload['visited_at'])->format('M d, Y')
            : '';

        return parent::from($payload);
    }
}
