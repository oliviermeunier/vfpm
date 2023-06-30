<?php

declare(strict_types=1);

use Fulll\Domain\Model\Fleet;
use Behat\Behat\Context\Context;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;

class RegisterVehicleContext implements Context
{

    use VehicleInMyFleetTrait;
    
    private Fleet $anotherUserFleet;
    private ?Exception $exception = null;


    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function assertVehicleInFleet(): void
    {
        assert($this->myFleet->hasVehicle($this->vehicle), 'Vehicle is not part of the fleet');
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function attemptToRegisterVehicle(): void
    {
        try {
            $this->myFleet->registerVehicle($this->vehicle);
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
        $this->anotherUserFleet = new Fleet('another-user-fleet');
    }

    /**
     * @Given This vehicle has been registered into the other user's fleet
     */
    public function registerVehicleIntoAnotherUserFleet(): void
    {
        $this->anotherUserFleet->registerVehicle($this->vehicle);
    }
}
