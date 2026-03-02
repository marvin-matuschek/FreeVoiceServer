<?php

declare(strict_types=1);

namespace App\Entity\Identity;

use App\Entity\Server;
use App\Repository\Identity\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /** @phpstan-ignore property.unusedType */
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 180, unique: true)]
    private string $globalId = '';

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Assert\NotBlank]
    #[ORM\Column]
    private string $password = '';

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(length: 255, unique: true)]
    private string $email = '';

    #[Assert\NotBlank]
    #[ORM\Column(length: 255, unique: true)]
    private string $username = '';

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Server $Server = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGlobalId(): string
    {
        return $this->globalId;
    }

    public function setGlobalId(string $globalId): static
    {
        $this->globalId = $globalId;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @throws LogicException
     */
    public function getUserIdentifier(): string
    {
        if ($this->username === '') {
            throw new LogicException('The user identifier cannot be empty.');
        }

        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->Server;
    }

    public function setServer(?Server $Server): static
    {
        $this->Server = $Server;

        return $this;
    }
}
