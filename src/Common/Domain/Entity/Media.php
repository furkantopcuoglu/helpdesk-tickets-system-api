<?php

namespace Common\Domain\Entity;

use User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\UuidTrait;
use Common\Application\Traits\CreatedAtTrait;
use Common\Infrastructure\Repositories\Doctrine\MediaRepository;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\Table(name: 'medias')]
class Media
{
    use UuidTrait;
    use CreatedAtTrait;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $path;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $module;

    #[ORM\Column(type: Types::STRING, length: 500)]
    private string $url;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getModule(): string
    {
        return $this->module;
    }

    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
