<?php

namespace App\Infrastructure\Command\Fixture;

use App\Application\Enum\CategoryType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Category\Create\CreateCategoryCommand;
use App\Application\Queries\Category\FindOneBy\FindOneByCategoryQuery;

#[AsCommand(
    name: 'fixture:category',
    description: 'Adds Default Category data',
)]
class FixtureCategoryCommand extends Command
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
        private readonly MessengerCommandBus $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        foreach (CategoryType::cases() as $category) {
            $isExist = $this->queryBus->handle(new FindOneByCategoryQuery([
                'name' => $category->value,
            ]));

            if ($isExist) {
                $style->error(sprintf('%s exist.', $category->value));

                continue;
            }

            $this->commandBus->handle(new CreateCategoryCommand([
                'name' => $category->value,
                'color' => CategoryType::getColor($category),
                'isDefault' => true,
            ]));

            $style->success(sprintf('%s added.', $category->value));
        }

        return Command::SUCCESS;
    }
}
