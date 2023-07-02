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

    public function save(Fleet $fleet): void
    {
        static::$fleetCollection[] = $fleet;
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
