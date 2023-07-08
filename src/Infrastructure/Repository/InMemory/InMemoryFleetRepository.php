<?php

namespace Fulll\Infrastructure\Repository\InMemory;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class InMemoryFleetRepository implements FleetRepositoryInterface
{
    /** @var array  */
    private static array $fleetCollection;

    public function __construct()
    {
        static::$fleetCollection = [];
    }

    /**
     * @param Fleet $fleet
     * @return FleetId
     * @throws \Exception
     */
    public function persist(Fleet $fleet): FleetId
    {
        $fleet->setId(new FleetId(UuidV4Generator::generate()));

        static::$fleetCollection[] = $fleet;

        return $fleet->getId();
    }

    /**
     * @param FleetId $id
     * @return Fleet|null
     */
    public function find(FleetId $id): ?Fleet
    {
        foreach (static::$fleetCollection as $fleet) {
            if ($fleet->getId()->equals($id)) {
                return $fleet;
            }
        }
        return null;
    }

    /**
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return void
     */
    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void
    {
    }

    /**
     * @return void
     */
    public function empty(): void
    {
        static::$fleetCollection = [];
    }

    /**
     * @param string $userId
     * @return Fleet|null
     */
    public function findByUserId(string $userId): ?Fleet
    {
        foreach (static::$fleetCollection as $fleet) {
            if ($fleet->getUserId() === $userId) {
                return $fleet;
            }
        }
        return null;
    }
}
