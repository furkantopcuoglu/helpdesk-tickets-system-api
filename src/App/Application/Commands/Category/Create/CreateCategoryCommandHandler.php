<?php

namespace App\Application\Commands\Category\Create;

use App\Domain\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateCategoryCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(CreateCategoryCommand $command): Category
    {
        $category = new Category();

        $category->setName($command->name);
        $category->setColor($command->color);
        $category->setIsDefault($command->isDefault);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}
