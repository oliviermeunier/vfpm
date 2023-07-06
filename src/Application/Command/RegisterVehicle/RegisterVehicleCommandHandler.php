<?php

namespace Fulll\Application\Command\RegisterVehicle;

use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Application\Command\RegisterVehicle\RegisterVehicleCommand;

class RegisterVehicleCommandHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
        private VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    public function __invoke(RegisterVehicleCommand $command): void
    {
        $fleetId = new FleetId($command->getFleetId());
        $fleet = $this->fleetRepository->find($fleetId);

        $plateNumber = $command->getVehiclePlateNumber();
        $vehicle = $this->vehicleRepository->findByPlateNumber($plateNumber);

        if (null === $vehicle) {
            $vehicle = new Vehicle($plateNumber);
            $this->vehicleRepository->persist($vehicle);
        }

        $fleet->registerVehicle($vehicle);
    }
}
