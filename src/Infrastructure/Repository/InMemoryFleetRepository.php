<?php

namespace Fulll\Infrastructure\Repository;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Interface\FleetRepositoryInterface;

class InMemoryFleetRepository implements FleetRepositoryInterface
{
    private static array $fleetCollection;

    public function __construct()
    {
        static::$fleetCollection = [];
    }

    public function persist(Fleet $fleet): string
    {
        $counter = count(static::$fleetCollection) + 1;
        $fleet->setId("fleet-$counter");

        static::$fleetCollection[] = $fleet;

        return $fleet->getId();
    }

    public function find(string $id): ?Fleet
    {
        foreach (static::$fleetCollection as $fleet) {
            if ($fleet->getId() === $id) {
                return $fleet;
            }
        }
        return null;
    }
}
