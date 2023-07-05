<?php

namespace Fulll\Infrastructure\Repository\InMemory;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class InMemoryFleetRepository implements FleetRepositoryInterface
{
    private static array $fleetCollection;

    public function __construct()
    {
        static::$fleetCollection = [];
    }

    public function persist(Fleet $fleet): FleetId
    {
        $fleet->setId(new FleetId(UuidV4Generator::generate()));

        static::$fleetCollection[] = $fleet;

        return $fleet->getId();
    }

    public function find(FleetId $id): ?Fleet
    {
        foreach (static::$fleetCollection as $fleet) {
            if ($fleet->getId()->equals($id)) {
                return $fleet;
            }
        }
        return null;
    }
}
