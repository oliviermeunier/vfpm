<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;

interface FleetRepositoryInterface
{
    public function persist(Fleet $fleet): string;
    public function find(FleetId $id): ?Fleet;
}
