<?php

namespace Common\Application\Commands\Media\Create;

use Common\Domain\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreateMediaCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateMediaCommand $command): Media
    {
        $media = new Media();

        $media->setName($command->name);
        $media->setPath($command->path);
        $media->setModule($command->module);
        $media->setUrl($command->url);
        $media->setUser($command->user);
        $media->setCreatedAt(new \DateTime());

        $this->entityManager->persist($media);
        $this->entityManager->flush();

        return $media;
    }
}
