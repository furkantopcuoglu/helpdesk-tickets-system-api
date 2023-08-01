<?php

namespace App\Application\Commands\Status\Create;

use App\Domain\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateStatusCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(CreateStatusCommand $command): Status
    {
        $status = new Status();

        $status->setName($command->name);
        $status->setColor($command->color);

        $this->entityManager->persist($status);
        $this->entityManager->flush();

        return $status;
    }
}
