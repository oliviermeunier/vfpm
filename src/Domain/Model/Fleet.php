<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;

class Fleet
{
    private FleetId $id;
    private string $userId;
    private array $vehicles = [];

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function setId(FleetId $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): FleetId
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function registerVehicle(Vehicle $vehicle): void
    {
        if ($this->hasVehicle($vehicle)) {
            throw new VehicleAlreadyRegisteredInFleetException();
        }

        $this->vehicles[] = $vehicle;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function hasVehicle(Vehicle $vehicle): bool
    {
        foreach ($this->vehicles as $fleetVehicle) {
            if ($vehicle->getId() === $fleetVehicle->getId()) {
                return true;
            }
        }
        return false;
    }
}
