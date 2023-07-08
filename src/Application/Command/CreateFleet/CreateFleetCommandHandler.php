<?php

namespace Fulll\Application\COmmand\CreateFleet;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Interface\FleetRepositoryInterface;

class CreateFleetCommandHandler
{
    /**
     * @param FleetRepositoryInterface $fleetRepository
     */
    public function __construct(private FleetRepositoryInterface $fleetRepository)
    {
    }

    /**
     * @param CreateFleetCommand $command
     * @return FleetId
     */
    public function __invoke(CreateFleetCommand $command): FleetId
    {
        $userId = $command->getUserId();

        $fleet = new Fleet($userId);
        $fleetId = $this->fleetRepository->persist($fleet);

        return $fleetId;
    }
}
