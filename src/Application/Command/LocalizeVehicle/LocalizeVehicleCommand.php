<?php 

namespace Fulll\Application\Command\LocalizeVehicle;

class LocalizeVehicleCommand {

    /**
     * @param string $fleetId
     * @param string $vehiclePlateNumber
     * @param float $lat
     * @param float $lng
     * @param float|null $alt
     */
    public function __construct(
        private string $fleetId,
        private string $vehiclePlateNumber,
        private float $lat,
        private float $lng,
        private ?float $alt = null
    )
    {}

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

    /**
     * @return float
     */
    public function getLat(): float 
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng(): float 
    {
        return $this->lng;
    }

    /**
     * @return float|null
     */
    public function getAlt(): ?float 
    {
        return $this->alt;
    }
}