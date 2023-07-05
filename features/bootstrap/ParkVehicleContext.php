<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\Domain\Model\Location;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Infrastructure\Repository\InMemory\InMemoryFleetRepository;
use Fulll\Infrastructure\Repository\InMemory\InMemoryVehicleRepository;

class ParkVehicleContext implements Context
{
    private FleetRepositoryInterface $fleetRepository;
    private VehicleRepositoryInterface $vehicleRepository;
    private Location $location;
    private ?Exception $exception = null;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->vehicleRepository = new InMemoryVehicleRepository();
    }

    /**
     * @Given a location
     */
    public function createLocation(): void
    {
        $this->location = new Location(43, 5);
    }

    /**
     * @When I park my vehicle at this location
     * @Given My vehicle has been parked into this location
     */
    public function parkVehicleAtLocation(): void
    {
        $myVehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        $myVehicle->park($this->location);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function assertKnownLocation(): void
    {
        $myVehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        $vehicleLocation = $myVehicle->getLocation();
        assert($vehicleLocation->equals($this->location), 'Known location does not match the specified location');
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function tryToParkVehicleAtLocation(): void
    {
        $myVehicle = $this->vehicleRepository->findByPlateNumber(SampleIdEnum::A_VEHICLE_PLATE_NUMBER->value);
        try {
            $myVehicle->park($this->location);
        } catch (VehicleAlreadyParkedAtLocationException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function assertRegistrationAttemptMessage(): void
    {
        $expectedMessage = VehicleAlreadyParkedAtLocationException::EXCEPTION_MESSAGE;
        $exceptionMessage = $this->exception?->getMessage();

        assert($expectedMessage === $exceptionMessage, 'Expected exception message not found');
    }
}
