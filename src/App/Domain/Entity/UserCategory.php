<?php

namespace App\Domain\Entity;

use User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\UuidTrait;
use App\Infrastructure\Repositories\Doctrine\CategoryRepository;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'user_categories')]
class UserCategory
{
    use UuidTrait;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userCategories')]
    private ?User $user;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
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
