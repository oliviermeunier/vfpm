<?php

namespace Fulll\Infrastructure\Repository\PDO;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Fulll\Infrastructure\Database\PDOConnection;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class PDOFleetRepository implements FleetRepositoryInterface
{
    public function persist(Fleet $fleet): FleetId
    {
        $uuidv4 = UuidV4Generator::generate();
        $fleet->setId(new FleetId($uuidv4));

        $pdo = PDOConnection::getPdo();
        $sql = 'INSERT INTO fleet (id, user_id) VALUES (:id, :userId)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $uuidv4);
        $statement->bindValue(':userId', $fleet->getUserId());
        $statement->execute();

        return $fleet->getId();
    }

    public function find(FleetId $id): ?Fleet
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'SELECT * FROM fleet WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id->getValue());
        $statement->execute();

        $fleetData = $statement->fetch();

        if (!$fleetData) {
            return null;
        }

        $fleet = new Fleet($fleetData['user_id']);
        $fleet->setId(new FleetId($fleetData['id']));

        return $fleet;
    }

    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'INSERT INTO r_fleet_vehicle (fleet_id, vehicle_id) VALUES (:fleet_id, :vehicle_id)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':fleet_id', $fleet->getId()->getValue());
        $statement->bindValue(':vehicle_id', $vehicle->getId()->getValue());
        $statement->execute();
    }
}
