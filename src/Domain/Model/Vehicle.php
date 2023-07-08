<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Model\Location;

class Vehicle
{
    /** @var VehicleId  */
    private VehicleId $id;

    /** @var PlateNumber  */
    private PlateNumber $plateNumber;

    /** @var Location|null  */
    private ?Location $location = null;

    /**
     * @param string $plateNumberValue
     */
    public function __construct(string $plateNumberValue)
    {
        $this->plateNumber = new PlateNumber($plateNumberValue);;
    }

    /**
     * @param VehicleId $id
     * @return $this
     */
    public function setId(VehicleId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return VehicleId
     */
    public function getId(): VehicleId
    {
        return $this->id;
    }

    /**
     * @return \Fulll\Domain\Model\Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param float|null $lat
     * @param float|null $lng
     * @param float|null $alt
     * @return $this
     */
    public function setLocation(?float $lat = null, ?float $lng = null, ?float $alt = null): self
    {
        $location = new Location($lat, $lng, $alt);
        $this->location = $location;
        return $this;
    }

    /**
     * @return PlateNumber
     */
    public function getPlateNumber(): PlateNumber
    {
        return $this->plateNumber;
    }

    /**
     * @param \Fulll\Domain\Model\Location $location
     * @return void
     * @throws VehicleAlreadyParkedAtLocationException
     */
    public function park(Location $location): void
    {
        if ($this->location?->equals($location)) {
            throw new VehicleAlreadyParkedAtLocationException();
        }

        $this->location = $location;
    }
}
