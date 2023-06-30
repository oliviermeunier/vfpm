<?php 

namespace Fulll\Domain\Model;

class Location
{
    public function __construct(
        private float $latitude,
        private float $longitude
    )
    {}

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function equals(self $location): bool
    {
        return $this->latitude === $location->latitude && $this->longitude === $location->longitude;
    }
}
