<?php 

namespace Fulll\Domain\Exception;

use Exception;

class VehicleAlreadyParkedAtLocationException extends Exception {

    const EXCEPTION_MESSAGE = 'This vehicle is already parked at this location';

    public function __construct()
    {
        parent::__construct(self::EXCEPTION_MESSAGE);
    }
}