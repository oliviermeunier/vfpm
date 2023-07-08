<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;

interface FleetRepositoryInterface
{
    public function persist(Fleet $fleet): FleetId;
    public function find(FleetId $id): ?Fleet;
    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void;
    public function empty(): void;
    public function findByUserId(string $userId): ?Fleet;
}
