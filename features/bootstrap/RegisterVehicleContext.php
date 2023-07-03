<?php

declare(strict_types=1);

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Behat\Behat\Context\Context;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Infrastructure\Repository\InMemoryFleetRepository;
use Fulll\Infrastructure\Repository\InMemoryVehicleRepository;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;

class RegisterVehicleContext implements Context
{
    private FleetRepositoryInterface $fleetRepository;
    private VehicleRepositoryInterface $vehicleRepository;
    private ?Exception $exception = null;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->vehicleRepository = new InMemoryVehicleRepository();
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function assertVehicleInFleet(): void
    {
        $myFleet = $this->fleetRepository->find(SampleIdEnum::MY_FLEET_ID->value);
        $vehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        assert($myFleet->hasVehicle($vehicle), 'Vehicle is not part of the fleet');
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function attemptToRegisterVehicle(): void
    {
        $myFleet = $this->fleetRepository->find(SampleIdEnum::MY_FLEET_ID->value);
        $vehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);

        try {
            $myFleet->registerVehicle($vehicle);
        } catch (VehicleAlreadyRegisteredInFleetException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function assertRegistrationAttemptMessage(): void
    {
        $expectedMessage = VehicleAlreadyRegisteredInFleetException::EXCEPTION_MESSAGE;
        $exceptionMessage = $this->exception?->getMessage();

        assert($expectedMessage === $exceptionMessage, 'Expected exception message not found');
    }

    /**
     * @Given the fleet of another user
     */
    public function createAnotherUserFleet()
    {
        $anotherUserFleet = new Fleet(
            SampleIdEnum::ANOTHER_USER_ID->value
        );
        $this->fleetRepository->persist($anotherUserFleet);
    }

    /**
     * @Given This vehicle has been registered into the other user's fleet
     */
    public function registerVehicleIntoAnotherUserFleet(): void
    {
        $anotherUserFleet = $this->fleetRepository->find(SampleIdEnum::ANOTHER_USER_FLEET_ID->value);
        $vehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        $anotherUserFleet->registerVehicle($vehicle);
    }
}
