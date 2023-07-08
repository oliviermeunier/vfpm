<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;

class Fleet
{
    /** @var FleetId  */
    private FleetId $id;

    /** @var string  */
    private string $userId;

    /**
     * @var array
     */
    private array $vehicles = [];

    /**
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param FleetId $id
     * @return $this
     */
    public function setId(FleetId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FleetId
     */
    public function getId(): FleetId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param Vehicle $vehicle
     * @return void
     * @throws VehicleAlreadyRegisteredInFleetException
     */
    public function registerVehicle(Vehicle $vehicle): void
    {
        if ($this->hasVehicle($vehicle)) {
            throw new VehicleAlreadyRegisteredInFleetException();
        }

        $this->vehicles[] = $vehicle;
    }

    /**
     * @return Vehicle[]
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    /**
     * @param Vehicle $vehicle
     * @return bool
     */
    public function hasVehicle(Vehicle $vehicle): bool
    {
        foreach ($this->vehicles as $fleetVehicle) {
            if ($vehicle->getId()->equals($fleetVehicle->getId())) {
                return true;
            }
        }
        return false;
    }
}
