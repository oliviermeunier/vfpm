<?php 

namespace Fulll\Application\Command\RegisterVehicle;

use Fulll\Domain\Model\Location;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Application\Command\LocalizeVehicle\LocalizeVehicleCommand;

class LocalizeVehicleCommandHandler {
        
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository
    )
    {}

    public function __invoke(LocalizeVehicleCommand $command): void
    {
        // $fleetId = $command->getFleetId(); // What is it for ?
        $vehicle = $this->vehicleRepository->findByPlateNumber($command->getVehiclePlateNumber());
        $location = new Location($command->getLat(), $command->getLng(), $command->getAlt());
        $vehicle->park($location);
    }
}