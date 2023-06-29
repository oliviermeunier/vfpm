<?php

declare(strict_types=1);

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Behat\Behat\Context\Context;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;

class RegisterVehicleContext implements Context
{
    

    private Fleet $fleet;
    private Vehicle $vehicle;
    private ?Exception $exception = null;

    /**
     * @Given my fleet
     */
    public function createFleet(): void
    {
        $this->fleet = new Fleet();
    }

    /**
     * @Given a vehicle
     */
    public function createVehicle(): void
    {
        $this->vehicle = new Vehicle('vehicle-1');
    }

    /**
     * @When I register this vehicle into my fleet
     * @Given I have registered this vehicle into my fleet
     */
    public function registerVehicle(): void
    {
        $this->fleet->registerVehicle($this->vehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function assertVehicleInFleet(): void
    {
        $fleetVehicles = $this->fleet->getVehicles();
        $fleetVehicleIds = array_map(fn ($vehicle) => $vehicle->getId(), $fleetVehicles);
        $vehicleId = $this->vehicle->getId();

        assert(in_array($vehicleId, $fleetVehicleIds), 'Vehicle is not part of the fleet');
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function attemptToRegisterVehicle(): void
    {
        try {
            $this->fleet->registerVehicle($this->vehicle);
        }
        catch(Exception $exception) {
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
}
