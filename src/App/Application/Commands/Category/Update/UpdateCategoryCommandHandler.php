<?php

namespace App\Application\Commands\Category\Update;

use App\Domain\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class UpdateCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateCategoryCommand $command): Category
    {
        $category = $command->category;

        if ($command->hasParameter('name')) {
            $category->setName($command->name);
        }

        if ($command->hasParameter('color')) {
            $category->setColor($command->color);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}
