<?php

namespace Fulll\Application\Command\CreateFleet;

class CreateFleetCommand
{
    /**
     * @param string $userId
     */
    public function __construct(private string $userId)
    {
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
