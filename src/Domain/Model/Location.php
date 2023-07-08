<?php

namespace Fulll\Domain\Model;

class Location
{
    /**
     * @param float|null $latitude
     * @param float|null $longitude
     * @param float|null $altitude
     */
    public function __construct(
        private ?float $latitude = null,
        private ?float $longitude = null,
        private ?float $altitude = null
    ) {
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float|null
     */
    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    /**
     * @param Location $location
     * @return bool
     */
    public function equals(self $location): bool
    {
        return $this->latitude === $location->latitude
            && $this->longitude === $location->longitude
            && $this->altitude === $location->altitude;
    }
}
