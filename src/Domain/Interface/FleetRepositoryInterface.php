<?php

namespace Fulll\Domain\Interface;

use Fulll\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function save(Fleet $fleet): void;
    public function find(string $id): ?Fleet;
}
