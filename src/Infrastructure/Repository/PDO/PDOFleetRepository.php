<?php

namespace Fulll\Infrastructure\Repository\PDO;

use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Fulll\Infrastructure\Database\PDOConnection;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Model\VehicleId;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class PDOFleetRepository implements FleetRepositoryInterface
{
    /**
     * @param Fleet $fleet
     * @return FleetId
     * @throws \Exception
     */
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

    /**
     * @param FleetId $id
     * @return Fleet|null
     */
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

    /**
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return void
     */
    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'INSERT INTO r_fleet_vehicle (fleet_id, vehicle_id) VALUES (:fleet_id, :vehicle_id)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':fleet_id', $fleet->getId()->getValue());
        $statement->bindValue(':vehicle_id', $vehicle->getId()->getValue());
        $statement->execute();
    }

    /**
     * @return void
     */
    public function empty(): void
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'DELETE FROM r_fleet_vehicle';
        $sql = 'DELETE FROM fleet';
        $pdo->exec($sql);
    }

    /**
     * @param string $userId
     * @return Fleet|null
     * @throws VehicleAlreadyRegisteredInFleetException
     */
    public function findByUserId(string $userId): ?Fleet
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'SELECT * FROM fleet WHERE user_id = :userId';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':userId', $userId);
        $statement->execute();

        $fleetData = $statement->fetch();

        if (!$fleetData) {
            return null;
        }

        $fleet = new Fleet($userId);
        $fleet->setId(new FleetId($fleetData['id']));

        $sql = 'SELECT * 
                FROM vehicle AS V 
                INNER JOIN r_fleet_vehicle AS R ON V.id = R.vehicle_id
                WHERE R.fleet_id = :fleetId';

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':fleetId', $fleetData['id']);
        $statement->execute();

        $vehiclesData = $statement->fetchAll();
        foreach ($vehiclesData as $vehicleData) {
            $vehicle = new Vehicle($vehicleData['plate_number']);
            $vehicle->setId(new VehicleId($vehicleData['id']));
            $vehicle->setLocation($vehicleData['lat'], $vehicleData['lng'], $vehicleData['alt']);

            $fleet->registerVehicle($vehicle);
        }

        return $fleet;
    }
}
