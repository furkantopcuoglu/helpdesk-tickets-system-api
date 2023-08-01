<?php

namespace App\Infrastructure\Command\Fixture;

use Ramsey\Uuid\Uuid;
use Doctrine\DBAL\Connection;
use App\Application\Enum\StatusType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQuery;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQueryHandler;

#[AsCommand(
    name: 'fixture:status',
    description: 'Adds Default Status data',
)]
class FixtureStatusCommand extends Command
{
    public function __construct(
        private readonly Connection $dbal,
        private readonly FindOneByStatusQueryHandler $findOneByStatusQueryHandler,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        foreach (StatusType::cases() as $status) {
            $isExist = $this->findOneByStatusQueryHandler->handle(new FindOneByStatusQuery([
                'name' => $status->value,
            ]));

            if ($isExist) {
                $style->error(sprintf('%s exist.', $status->value));

                continue;
            }

            $this->dbal->insert('statuses', [
                'id' => Uuid::uuid4()->toString(),
                'name' => $status->value,
                'color' => StatusType::getColor($status),
            ]);

            $style->success(sprintf('%s added.', $status->value));
        }

        return Command::SUCCESS;
    }
}
