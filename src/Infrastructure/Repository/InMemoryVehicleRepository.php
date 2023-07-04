<?php

namespace Fulll\Infrastructure\Repository;

use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Domain\Model\VehicleId;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class InMemoryVehicleRepository implements VehicleRepositoryInterface
{
    private static array $vehicleCollection;

    public function __construct()
    {
        static::$vehicleCollection = [];
    }

    public function persist(Vehicle $vehicle): string
    {
        $vehicle->setId(new VehicleId(UuidV4Generator::generate()));

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
