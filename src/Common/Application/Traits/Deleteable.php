<?php

namespace Common\Application\Traits;

use User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait Deleteable
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $deletedAt;

    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => false])]
    protected ?bool $isDeleted = false;

    #[ORM\ManyToOne(targetEntity: 'User\Domain\Entity\User')]
    protected ?User $deletedBy;

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?User $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
}
