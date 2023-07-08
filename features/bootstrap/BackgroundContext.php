<?php

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Behat\Behat\Context\Context;
use Symfony\Component\Dotenv\Dotenv;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Infrastructure\Repository\PDO\PDOFleetRepository;
use Fulll\Infrastructure\Repository\PDO\PDOVehicleRepository;
use Fulll\Infrastructure\Repository\InMemory\InMemoryFleetRepository;
use Fulll\Infrastructure\Repository\InMemory\InMemoryVehicleRepository;

class BackgroundContext implements Context
{
    private FleetRepositoryInterface $fleetRepository;
    private VehicleRepositoryInterface $vehicleRepository;

    /**
     * @BeforeSuite
     */
    public static function prepare()
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__ . '/../../.env.local');
    }

    /** 
     * @BeforeScenario 
     */
    public function before(BeforeScenarioScope $scope)
    {
        if (in_array('critical', $scope->getScenario()->getTags())) {
            $this->fleetRepository = new PDOFleetRepository();
            $this->vehicleRepository = new PDOVehicleRepository();
        } else {
            $this->fleetRepository = new InMemoryFleetRepository();
            $this->vehicleRepository = new InMemoryVehicleRepository();
        }
    }

    /**
     * @Given my fleet
     */
    public function createFleet(): void
    {
        $myFleet = new Fleet(SampleIdEnum::MY_USER_ID->value);
        $this->fleetRepository->persist($myFleet);
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
        $myFleet = $this->fleetRepository->findByUserId(SampleIdEnum::MY_USER_ID->value);
        $vehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);

        $myFleet->registerVehicle($vehicle);
        $this->fleetRepository->registerVehicle($myFleet, $vehicle);
    }
}
