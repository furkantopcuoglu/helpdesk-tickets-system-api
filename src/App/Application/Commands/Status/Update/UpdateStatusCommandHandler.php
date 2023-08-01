<?php

namespace App\Application\Commands\Status\Update;

use App\Domain\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;

readonly class UpdateStatusCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(UpdateStatusCommand $command): Status
    {
        $status = $command->status;

        if ($command->hasParameter('name')) {
            $status->setName($command->name);
        }

        if ($command->hasParameter('color')) {
            $status->setColor($command->color);
        }

        $this->entityManager->persist($status);
        $this->entityManager->flush();

        return $status;
    }
}
