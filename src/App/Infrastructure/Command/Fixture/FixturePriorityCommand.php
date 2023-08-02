<?php

namespace App\Infrastructure\Command\Fixture;

use App\Application\Enum\PriorityType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Priority\Create\CreatePriorityCommand;
use App\Application\Queries\Priority\FindOneBy\FindOneByPriorityQuery;

#[AsCommand(
    name: 'fixture:priority',
    description: 'Adds Default Priority data',
)]
class FixturePriorityCommand extends Command
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

        foreach (PriorityType::cases() as $priority) {
            $isExist = $this->queryBus->handle(new FindOneByPriorityQuery([
                'name' => $priority->value,
            ]));

            if ($isExist) {
                $style->error(sprintf('%s exist.', $priority->value));

                continue;
            }

            $this->commandBus->handle(new CreatePriorityCommand([
                'name' => $priority->value,
                'color' => PriorityType::getColor($priority),
            ]));

            $style->success(sprintf('%s added.', $priority->value));
        }

        return Command::SUCCESS;
    }
}
