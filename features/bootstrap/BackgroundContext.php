<?php

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Behat\Behat\Context\Context;
use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Infrastructure\Repository\InMemory\InMemoryFleetRepository;
use Fulll\Infrastructure\Repository\InMemory\InMemoryVehicleRepository;

class BackgroundContext implements Context
{
    private FleetRepositoryInterface $fleetRepository;
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->vehicleRepository = new InMemoryVehicleRepository();
    }

    /**
     * @Given my fleet
     */
    public function createFleet(): void
    {
        $myFleet = new Fleet(SampleIdEnum::MY_USER_ID->value);
        $this->fleetRepository->persist($myFleet);
        $myFleet->setId(new FleetId(SampleIdEnum::MY_FLEET_ID->value));
    }

    /**
     * @Given a vehicle
     */
    public function createVehicle(): void
    {
        $vehicle = new Vehicle(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        $this->vehicleRepository->persist($vehicle);
    }

    /**
     * @When I register this vehicle into my fleet
     * @Given I have registered this vehicle into my fleet
     */
    public function registerVehicleIntoMyFleet(): void
    {
        $myFleet = $this->fleetRepository->find(new FleetId(SampleIdEnum::MY_FLEET_ID->value));
        $vehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        $myFleet->registerVehicle($vehicle);
    }
}
