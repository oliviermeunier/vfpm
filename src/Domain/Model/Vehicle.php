<?php 

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Model\Location;

class Vehicle
{
    public function __construct(
        private string $id,
        private ?Location $location = null
    )
    {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocation(): ?Location 
    {
        return $this->location;
    }

    public function park(Location $location): void 
    {
        if ($this->location?->equals($location)) {
            throw new VehicleAlreadyParkedAtLocationException();
        }

        $this->location = $location;

    }
}