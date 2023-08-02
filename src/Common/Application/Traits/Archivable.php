<?php

namespace Common\Application\Traits;

use User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait Archivable
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $archiveAt;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: ['default' => false])]
    protected ?bool $isArchive = false;

    #[ORM\ManyToOne(targetEntity: 'User\Domain\Entity\User')]
    protected ?User $archiveBy;

    public function getArchiveAt(): ?\DateTimeInterface
    {
        return $this->archiveAt;
    }

    public function setArchiveAt(?\DateTimeInterface $archiveAt): void
    {
        $this->archiveAt = $archiveAt;
    }

    public function getIsArchive(): ?bool
    {
        return $this->isArchive;
    }

    public function setIsArchive(?bool $isArchive): void
    {
        $this->isArchive = $isArchive;
    }

    public function getArchiveBy(): ?User
    {
        return $this->archiveBy;
    }

    public function setArchiveBy(?User $archiveBy): void
    {
        $this->archiveBy = $archiveBy;
    }
}
