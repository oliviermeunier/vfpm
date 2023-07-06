<?php

namespace Fulll\Infrastructure\Repository\PDO;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Model\VehicleId;
use Fulll\Infrastructure\Database\PDOConnection;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Interface\VehicleRepositoryInterface;
use Fulll\Domain\Model\PlateNumber;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;

class PDOVehicleRepository implements VehicleRepositoryInterface
{
    public function persist(Vehicle $Vehicle): VehicleId
    {
        $uuidv4 = UuidV4Generator::generate();
        $Vehicle->setId(new VehicleId($uuidv4));

        $pdo = PDOConnection::getPdo();
        $sql = 'INSERT INTO vehicle (id, plate_number) VALUES (:id, :plateNumber)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $uuidv4);
        $statement->bindValue(':plateNumber', $Vehicle->getPlateNumber()->getValue());
        $statement->execute();

        return $Vehicle->getId();
    }

    public function findByPlateNumber(string|PlateNumber $plateNumber): ?Vehicle
    {
        $plateNumberValue = ($plateNumber instanceof PlateNumber) ? $plateNumber->getValue() : $plateNumber;

        $pdo = PDOConnection::getPdo();
        $sql = 'SELECT * FROM vehicle WHERE plate_number = :plate_number';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':plate_number', $plateNumberValue);
        $statement->execute();

        $vehicleData = $statement->fetch();

        if (!$vehicleData) {
            return null;
        }

        $fleet = new Vehicle($vehicleData['plate_number']);
        $fleet->setId(new VehicleId($vehicleData['id']));

        return $fleet;
    }
}
