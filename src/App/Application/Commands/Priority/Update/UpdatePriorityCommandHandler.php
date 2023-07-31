<?php

namespace App\Application\Commands\Priority\Update;

use App\Domain\Entity\Priority;
use Doctrine\ORM\EntityManagerInterface;

readonly class UpdatePriorityCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(UpdatePriorityCommand $command): Priority
    {
        $priority = $command->priority;

        if ($command->hasParameter('name')) {
            $priority->setName($command->name);
        }

        if ($command->hasParameter('color')) {
            $priority->setColor($command->color);
        }

        $this->entityManager->persist($priority);
        $this->entityManager->flush();

        return $priority;
    }
}
