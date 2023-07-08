<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Model\VehicleId;

interface VehicleRepositoryInterface
{
    public function persist(Vehicle $vehicle): VehicleId;
    public function findByPlateNumber(string|PlateNumber $plateNumber): ?Vehicle;
    public function updateLocalization(Vehicle $vehicle): void;
}
