<?php

namespace User\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Entity\UserCategory;
use Common\Application\Traits\UuidTrait;
use Common\Application\Traits\Deleteable;
use Doctrine\Common\Collections\Collection;
use Common\Application\Traits\CreatedAtTrait;
use Common\Application\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Infrastructure\Repositories\Doctrine\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use UuidTrait;
    use Deleteable;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Groups(groups: ['userDetail'])]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Groups(groups: ['userDetail'])]
    private string $surname;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    #[Groups(groups: ['userDetail'])]
    private string $email;

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => null])]
    private ?\DateTimeInterface $tokenValidAfter = null;

    /**
     * @var Collection<int, UserCategory>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserCategory::class, fetch: 'EAGER', )]
    private Collection $userCategories;

    public function __construct()
    {
        $this->userCategories = new ArrayCollection();
    }

    /**
     * @see UserInterface
     *
     * @return void
     */
    public function eraseCredentials()
    {
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): self
    {
        $roles[] = 'ROLE_USER';
        $this->roles = array_unique($roles);

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getTokenValidAfter(): ?\DateTimeInterface
    {
        return $this->tokenValidAfter;
    }

    public function setTokenValidAfter(?\DateTimeInterface $tokenValidAfter): void
    {
        $this->tokenValidAfter = $tokenValidAfter;
    }

    public function getUserCategories(): Collection
    {
        return $this->userCategories;
    }
}
