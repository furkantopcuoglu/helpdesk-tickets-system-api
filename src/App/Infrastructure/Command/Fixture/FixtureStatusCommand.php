<?php

namespace App\Infrastructure\Command\Fixture;

use App\Application\Enum\StatusType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Status\Create\CreateStatusCommand;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQuery;

#[AsCommand(
    name: 'fixture:status',
    description: 'Adds Default Status data',
)]
class FixtureStatusCommand extends Command
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        foreach (StatusType::cases() as $status) {
            $isExist = $this->queryBus->handle(new FindOneByStatusQuery([
                'name' => $status->value,
            ]));

            if ($isExist) {
                $style->error(sprintf('%s exist.', $status->value));

                continue;
            }

            $this->commandBus->handle(new CreateStatusCommand([
                'name' => $status->value,
                'color' => StatusType::getColor($status),
            ]));

            $style->success(sprintf('%s added.', $status->value));
        }

        return Command::SUCCESS;
    }
}
