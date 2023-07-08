<?php

namespace Fulll\Infrastructure\Repository\InMemory;

use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Domain\Model\VehicleId;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class InMemoryVehicleRepository implements VehicleRepositoryInterface
{
    /** @var array  */
    private static array $vehicleCollection;

    public function __construct()
    {
        static::$vehicleCollection = [];
    }

    /**
     * @param Vehicle $vehicle
     * @return VehicleId
     * @throws \Exception
     */
    public function persist(Vehicle $vehicle): VehicleId
    {
        $vehicle->setId(new VehicleId(UuidV4Generator::generate()));

        static::$vehicleCollection[] = $vehicle;

        return $vehicle->getId();
    }

    /**
     * @param string|PlateNumber $plateNumber
     * @return Vehicle|null
     */
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

    /**
     * @param Vehicle $vehicle
     * @return void
     */
    public function updateLocalization(Vehicle $vehicle): void
    {
    }

    /**
     * @return void
     */
    public function empty(): void
    {
        static::$vehicleCollection = [];
    }
}
