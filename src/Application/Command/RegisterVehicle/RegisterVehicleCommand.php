<?php

namespace Fulll\Application\Command\RegisterVehicle;

class RegisterVehicleCommand
{
    /**
     * @param string $fleetId
     * @param string $vehiclePlateNumber
     */
    public function __construct(
        private string $fleetId,
        private string $vehiclePlateNumber
    ) {
    }

    /**
     * @return string
     */
    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    /**
     * @return string
     */
    public function getVehiclePlateNumber(): string
    {
        return $this->vehiclePlateNumber;
    }
}
