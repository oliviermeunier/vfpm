<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function persist(Fleet $fleet): string;
    public function find(string $id): ?Fleet;
}
