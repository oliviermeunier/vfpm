<?php

namespace Fulll\Application\Command\CreateFleet;

class CreateFleetCommand
{

    public function __construct(private string $userId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
