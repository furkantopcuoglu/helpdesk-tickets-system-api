<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\UuidTrait;
use App\Infrastructure\Repositories\Doctrine\PriorityRepository;

#[ORM\Entity(repositoryClass: PriorityRepository::class)]
#[ORM\Table(name: 'priorities')]
class Priority
{
    use UuidTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $color;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}
