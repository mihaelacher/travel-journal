<?php

namespace App\Data\Map;

use App\Services\Utils\ExternalApiUtil;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class MapLocationData extends Data {

    public function __construct(
        public ?string $icon,
        public ?string $name,
        #[MapInputName('geometry.location.lat')]
        public ?float $latitude,
        #[MapInputName('geometry.location.lng')]
        public ?float $longitude,
        #[MapInputName('types')]
        public array $additional_info,
        public array $photo_urls
    ) {
    }

    public static function from(mixed ...$payloads): static
    {
        $payload = reset($payloads);
        $payload['photo_references'] = json_encode(array_column($payload['photos'] ?? [], 'photo_reference') ?? []);
        $payload['photo_urls'] = ExternalApiUtil::buildPlacePhotoUrls($payload);

        return parent::from($payload);
    }
}
