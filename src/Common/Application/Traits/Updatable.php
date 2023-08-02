<?php

namespace Common\Application\Traits;

use User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait Updatable
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['index', 'updatedAt'])]
    protected ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: 'User\Domain\Entity\User')]
    protected ?User $updatedBy;

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
}
