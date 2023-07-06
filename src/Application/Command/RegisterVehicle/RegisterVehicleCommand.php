<?php

namespace Fulll\Application\Command\RegisterVehicle;

class RegisterVehicleCommand
{
    public function __construct(
        private string $fleetId,
        private string $vehiclePlateNumber
    ) {
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function getVehiclePlateNumber(): string
    {
        return $this->vehiclePlateNumber;
    }
}
