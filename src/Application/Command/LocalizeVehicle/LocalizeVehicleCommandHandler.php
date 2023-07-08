<?php

namespace Fulll\Application\Command\LocalizeVehicle;

use Exception;
use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Model\Location;
use Fulll\Domain\Interface\VehicleRepositoryInterface;

class LocalizeVehicleCommandHandler
{
    /**
     * @param VehicleRepositoryInterface $vehicleRepository
     */
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    /**
     * @param LocalizeVehicleCommand $command
     * @return void
     * @throws VehicleAlreadyParkedAtLocationException
     */
    public function __invoke(LocalizeVehicleCommand $command): void
    {
        // $fleetId = $command->getFleetId(); // What is it for ?
        $vehicle = $this->vehicleRepository->findByPlateNumber($command->getVehiclePlateNumber());

        if (!$vehicle) {
            throw new Exception('Vehicle not found');
        }

        $location = new Location($command->getLat(), $command->getLng(), $command->getAlt());
        $vehicle->park($location);
        $this->vehicleRepository->updateLocalization($vehicle);
    }
}
