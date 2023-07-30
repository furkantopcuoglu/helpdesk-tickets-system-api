<?php

namespace Common\Application\Traits;

use User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

trait Creation
{
    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: 'User\Domain\Entity\User')]
    protected ?UserInterface $createdBy;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt = null): static
    {
        if (null === $createdAt) {
            $createdAt = new \DateTime();
        }

        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
