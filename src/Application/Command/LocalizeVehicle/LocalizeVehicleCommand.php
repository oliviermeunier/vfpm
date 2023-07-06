<?php 

namespace Fulll\Application\Command\LocalizeVehicle;

class LocalizeVehicleCommand {
    
    public function __construct(
        private string $fleetId,
        private string $vehiclePlateNumber,
        private float $lat,
        private float $lng,
        private ?float $alt = null
    )
    {}

    public function getFleetId(): string 
    {
        return $this->fleetId;
    }

    public function getVehiclePlateNumber(): string 
    {
        return $this->vehiclePlateNumber;
    }

    public function getLat(): float 
    {
        return $this->lat;
    }

    public function getLng(): float 
    {
        return $this->lng;
    }

    public function getAlt(): ?float 
    {
        return $this->alt;
    }
}