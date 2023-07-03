<?php 

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Model\Location;

class Vehicle
{
    private string $id;
    private PlateNumber $plateNumber;
    private ?Location $location = null;

    public function __construct(string $plateNumberValue)
    {
        $this->plateNumber = new PlateNumber($plateNumberValue);;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocation(): ?Location 
    {
        return $this->location;
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