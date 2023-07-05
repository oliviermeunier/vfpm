<?php

namespace Fulll\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Fulll\Infrastructure\Repository\PDO\PDOFleetRepository;
use Fulll\Application\COmmand\CreateFleet\CreateFleetCommand;
use Fulll\Application\COmmand\CreateFleet\CreateFleetCommandHandler;
use Fulll\Infrastructure\Repository\InMemory\InMemoryFleetRepository;

class CreateFleetSymfonyCommand extends Command
{
    protected function configure()
    {
        $this->setName('create')
            ->setDescription('Cretae a brand new fleet')
            ->setHelp('php bin/fleet create <user-id>')
            ->addArgument('user-id', InputArgument::REQUIRED, 'User Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('user-id');
        $command = new CreateFleetCommand($userId);
        $handler = new CreateFleetCommandHandler(new PDOFleetRepository());
        $fleetId = $handler($command);

        $output->writeln(sprintf('Fleet created successfully with ID %s', $fleetId));
        return Command::SUCCESS;
    }
}