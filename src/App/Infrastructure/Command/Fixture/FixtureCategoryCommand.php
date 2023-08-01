<?php

namespace App\Infrastructure\Command\Fixture;

use Ramsey\Uuid\Uuid;
use Doctrine\DBAL\Connection;
use App\Application\Enum\CategoryType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Queries\Category\FindOneBy\FindOneByCategoryQuery;
use App\Application\Queries\Category\FindOneBy\FindOneByCategoryQueryHandler;

#[AsCommand(
    name: 'fixture:category',
    description: 'Adds Default Category data',
)]
class FixtureCategoryCommand extends Command
{
    public function __construct(
        private readonly Connection $dbal,
        private readonly FindOneByCategoryQueryHandler $findOneByCategoryQueryHandler,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        foreach (CategoryType::cases() as $category) {
            $isExist = $this->findOneByCategoryQueryHandler->handle(new FindOneByCategoryQuery([
                'name' => $category->value,
            ]));

            if ($isExist) {
                $style->error(sprintf('%s exist.', $category->value));

                continue;
            }

            $this->dbal->insert('categories', [
                'id' => Uuid::uuid4()->toString(),
                'name' => $category->value,
                'color' => CategoryType::getColor($category),
                'is_default' => true,
            ]);

            $style->success(sprintf('%s added.', $category->value));
        }

        return Command::SUCCESS;
    }
}
