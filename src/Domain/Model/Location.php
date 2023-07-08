<?php

namespace Fulll\Domain\Model;

class Location
{
    public function __construct(
        private ?float $latitude = null,
        private ?float $longitude = null,
        private ?float $altitude = null
    ) {
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function equals(self $location): bool
    {
        return $this->latitude === $location->latitude
            && $this->longitude === $location->longitude
            && $this->altitude === $location->altitude;
    }
}
