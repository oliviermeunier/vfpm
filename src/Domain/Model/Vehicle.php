<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Model\Location;

class Vehicle
{
    private VehicleId $id;
    private PlateNumber $plateNumber;
    private ?Location $location = null;

    public function __construct(string $plateNumberValue)
    {
        $this->plateNumber = new PlateNumber($plateNumberValue);;
    }

    public function setId(VehicleId $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): VehicleId
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?float $lat = null, ?float $lng = null, ?float $alt = null): self
    {
        $location = new Location($lat, $lng, $alt);
        $this->location = $location;
        return $this;
    }

    public function getPlateNumber(): PlateNumber
    {
        return $this->plateNumber;
    }

    public function park(Location $location): void
    {
        if ($this->location?->equals($location)) {
            throw new VehicleAlreadyParkedAtLocationException();
        }

        $this->location = $location;
    }
}
