<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ServerService;
use LogicException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:setup', description: 'Set up the application')]
readonly class SetupCommand
{
    public function __construct(
        private ServerService $serverService,
    ) {}

    public function __invoke(OutputInterface $output): int
    {
        try {
            $this->serverService->setup();
        } catch (LogicException $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
