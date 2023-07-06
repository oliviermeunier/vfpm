<?php

namespace Fulll\Infrastructure\Command;

use Exception;
use InvalidArgumentException;
use Fulll\Domain\Model\FleetId;
use Fulll\Domain\Model\PlateNumber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Fulll\Infrastructure\Repository\PDO\PDOFleetRepository;
use Fulll\Infrastructure\Repository\PDO\PDOVehicleRepository;
use Fulll\Application\Command\RegisterVehicle\RegisterVehicleCommand;
use Fulll\Application\Command\RegisterVehicle\RegisterVehicleCommandHandler;

class RegisterVehicleSymfonyCommand extends Command
{
    protected function configure()
    {
        $this->setName('register-vehicle')
            ->setDescription('Register a vehicle into a fleet')
            ->setHelp('php bin/fleet register-vehicle <fleet-id> <plate-number>')
            ->addArgument('fleet-id', InputArgument::REQUIRED, 'Fleet Id')
            ->addArgument('plate-number', InputArgument::REQUIRED, 'Vehicle plate number');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $command = new RegisterVehicleCommand(
                $input->getArgument('fleet-id'),
                $input->getArgument('plate-number')
            );

            $handler = new RegisterVehicleCommandHandler(
                new PDOFleetRepository(),
                new PDOVehicleRepository()
            );

            $handler($command);

            $output->writeln(sprintf('Vehicle registered successfully into fleet'));
            return Command::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
