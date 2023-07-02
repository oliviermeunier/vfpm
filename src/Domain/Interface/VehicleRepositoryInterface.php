<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function save(Vehicle $vehicle): void;
    public function find(string $id): ?Vehicle;
}
