<?php

namespace App\Application\Commands\Category\Update;

use App\Domain\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

readonly class UpdateCategoryCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(UpdateCategoryCommand $command): Category
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
