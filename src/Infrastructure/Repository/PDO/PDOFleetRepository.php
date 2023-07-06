<?php

namespace Fulll\Infrastructure\Repository\PDO;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;
use Fulll\Infrastructure\Database\PDOConnection;

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

        $fleet = new Fleet($fleetData['user_id']);
        $fleet->setId(new FleetId($fleetData['id']));

        return $fleet;
    }
}
