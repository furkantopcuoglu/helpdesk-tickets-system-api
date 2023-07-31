<?php

namespace App\Application\Commands\Priority\Create;

use App\Domain\Entity\Priority;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreatePriorityCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(CreatePriorityCommand $command): Priority
    {
        $priority = new Priority();

        $priority->setName($command->name);
        $priority->setColor($command->color);

        $this->entityManager->persist($priority);
        $this->entityManager->flush();

        return $priority;
    }
}
