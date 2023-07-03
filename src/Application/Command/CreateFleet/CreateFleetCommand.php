<?php 

namespace Fulll\Application\COmmand\CreateFleet;

class CreateFleetCommand {
    
    public function __construct(private string $userId)
    {}

    public function getUserId(): string 
    {
        return $this->userId;
    }
}