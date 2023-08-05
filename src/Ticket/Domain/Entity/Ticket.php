<?php

namespace Ticket\Domain\Entity;

use User\Domain\Entity\User;
use App\Domain\Entity\Status;
use Doctrine\DBAL\Types\Types;
use App\Domain\Entity\Category;
use App\Domain\Entity\Priority;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\Updatable;
use Common\Application\Traits\UuidTrait;
use Common\Application\Traits\Archivable;
use Common\Application\Traits\Deleteable;
use Common\Application\Traits\CreatedAtTrait;
use Common\Application\Traits\CompletedAtTrait;
use Ticket\Infrastructure\Repositories\Doctrine\TicketRepository;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ORM\Table(name: 'tickets')]
class Ticket
{
    use UuidTrait;
    use CreatedAtTrait;
    use CompletedAtTrait;
    use Updatable;
    use Deleteable;
    use Archivable;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $subject;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $ticketNo;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\ManyToOne(targetEntity: Priority::class)]
    private ?Priority $priority;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    private ?Status $status;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $support;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $owner;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category;

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): void
    {
        $this->priority = $priority;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): void
    {
        $this->status = $status;
    }

    public function getSupport(): ?User
    {
        return $this->support;
    }

    public function setSupport(?User $support): void
    {
        $this->support = $support;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function getTicketNo(): string
    {
        return $this->ticketNo;
    }

    public function setTicketNo(string $ticketNo): void
    {
        $this->ticketNo = $ticketNo;
    }
}
