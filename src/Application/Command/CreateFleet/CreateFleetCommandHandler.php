<?php 

namespace Fulll\Application\COmmand\CreateFleet;

use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;

class CreateFleetCommandHandler {
    
    public function __construct(
        private FleetRepositoryInterface $fleetRepository
    )
    {
        
    }

    public function __invoke(CreateFleetCommand $command): FleetId
    {
        $userId = $command->getUserId();        
        $fleet = new Fleet($userId);
        $fleetId = $this->fleetRepository->persist($fleet);

        return $fleetId;
    }
}