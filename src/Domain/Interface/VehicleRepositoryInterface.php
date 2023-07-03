<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function persist(Vehicle $vehicle): string;
    public function findByPlateNumber(string|PlateNumber $plateNumber): ?Vehicle;
}
