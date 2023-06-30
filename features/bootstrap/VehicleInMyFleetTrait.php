<?php 

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;

trait VehicleInMyFleetTrait {

    private Fleet $myFleet;
    private Vehicle $vehicle;
    
    /**
     * @Given my fleet
     */
    public function createFleet(): void
    {
        $this->myFleet = new Fleet('my-fleet');
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
    public function registerVehicleIntoMyFleet(): void
    {
        $this->myFleet->registerVehicle($this->vehicle);
    }
}