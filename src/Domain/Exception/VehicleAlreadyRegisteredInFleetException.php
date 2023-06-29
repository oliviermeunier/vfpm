<?php 

namespace Fulll\Domain\Exception;

use Exception;

class VehicleAlreadyRegisteredInFleetException extends Exception {

    const EXCEPTION_MESSAGE = 'This vehicle is already registered in your fleet';

    public function __construct()
    {
        parent::__construct(self::EXCEPTION_MESSAGE);
    }
}