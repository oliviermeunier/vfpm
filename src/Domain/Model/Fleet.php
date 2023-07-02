<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;

class Fleet
{
    public function __construct(
        private string $id,
        private string $userId,
        private array $vehicles = []
    ) {
    }

    public function getId(): string
    {
        return $this->id;
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
