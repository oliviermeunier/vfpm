<?php

namespace Fulll\Infrastructure\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Fulll\Infrastructure\Repository\PDO\PDOVehicleRepository;
use Fulll\Application\Command\LocalizeVehicle\LocalizeVehicleCommand;
use Fulll\Application\Command\LocalizeVehicle\LocalizeVehicleCommandHandler;

class LocalizeVehicleSymfonyCommand extends Command
{
    protected function configure()
    {
        $this->setName('localize-vehicle')
            ->setDescription('Localize a vehicle')
            ->setHelp('php bin/fleet localize-vehicle <fleet-id> <plate-number> <lat> <lng> [alt]')
            ->addArgument('fleet-id', InputArgument::REQUIRED, 'Fleet Id')
            ->addArgument('plate-number', InputArgument::REQUIRED, 'Vehicle plate number')
            ->addArgument('lat', InputArgument::REQUIRED, 'Latitude')
            ->addArgument('lng', InputArgument::REQUIRED, 'Longitude')
            ->addArgument('alt', InputArgument::OPTIONAL, 'Altitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $command = new LocalizeVehicleCommand(
                $input->getArgument('fleet-id'),
                $input->getArgument('plate-number'),
                $input->getArgument('lat'),
                $input->getArgument('lng'),
                $input->getArgument('alt')
            );

            $handler = new LocalizeVehicleCommandHandler(
                new PDOVehicleRepository()
            );

            $handler($command);

            $output->writeln(sprintf('Vehicle successfully localized'));
            return Command::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
