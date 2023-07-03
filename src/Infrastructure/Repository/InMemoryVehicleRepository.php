<?php

namespace Fulll\Infrastructure\Repository;

use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Interface\VehicleRepositoryInterface;

class InMemoryVehicleRepository implements VehicleRepositoryInterface
{
    private static array $vehicleCollection;

    public function __construct()
    {
        static::$vehicleCollection = [];
    }

    public function persist(Vehicle $vehicle): string
    {
        $counter = count(static::$vehicleCollection) + 1;
        $vehicle->setId("vehicle-$counter");

        static::$vehicleCollection[] = $vehicle;

        return $vehicle->getId();
    }

    public function findByPlateNumber(string|PlateNumber $plateNumber): ?Vehicle
    {
        if (is_string($plateNumber)) {
            $plateNumber = new PlateNumber($plateNumber);
        }

        foreach (static::$vehicleCollection as $vehicle) {
            if ($vehicle->getPlateNumber()->equals($plateNumber)) {
                return $vehicle;
            }
        }
        return null;
    }
}
