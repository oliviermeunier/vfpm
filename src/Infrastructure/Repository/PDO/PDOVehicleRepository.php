<?php

namespace Fulll\Infrastructure\Repository\PDO;

use PDO;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Model\Location;
use Fulll\Domain\Model\VehicleId;
use Fulll\Domain\Model\PlateNumber;
use Fulll\Infrastructure\Database\PDOConnection;
use Fulll\Domain\Interface\FleetRepositoryInterface;
use Fulll\Domain\Shared\ValueObject\UuidV4Generator;
use Fulll\Domain\Interface\VehicleRepositoryInterface;

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

        $vehicle = new Vehicle($vehicleData['plate_number']);
        $vehicle->setId(new VehicleId($vehicleData['id']));
        $vehicle->setLocation($vehicleData['lat'], $vehicleData['lng'], $vehicleData['alt']);

        return $vehicle;
    }

    public function updateLocalization(Vehicle $vehicle): void
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'UPDATE vehicle SET lat = :lat, lng = :lng, alt = :alt WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':lat', $vehicle->getLocation()->getLatitude());
        $statement->bindValue(':lng', $vehicle->getLocation()->getLongitude());
        $statement->bindValue(':alt', $vehicle->getLocation()->getAltitude());
        $statement->bindValue(':id', $vehicle->getId()->getValue());

        $statement->execute();
    }

    public function empty(): void
    {
        $pdo = PDOConnection::getPdo();
        $sql = 'DELETE FROM vehicle';
        $pdo->exec($sql);
    }
}
