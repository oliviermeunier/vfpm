<?php

namespace Fulll\Infrastructure\Repository;

use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Interface\VehicleRepositoryInterface;

class InMemoryVehicleRepository implements VehicleRepositoryInterface
{
    private static array $vehicleCollection;

    public function __construct()
    {
        static::$vehicleCollection = [];
    }

    public function save(Vehicle $vehicle): void
    {
        static::$vehicleCollection[] = $vehicle;
    }

    public function find(string $id): ?Vehicle
    {
        foreach (static::$vehicleCollection as $vehicle) {
            if ($vehicle->getId() === $id) {
                return $vehicle;
            }
        }
        return null;
    }
}
