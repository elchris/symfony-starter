<?php

namespace App\Entity;

use App\Repository\AppUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=AppUserRepository::class)
 * @ORM\Table(
 *     indexes={
 *          @Index(
 *              name="appuser_email_idx",
 *              columns={"email"}
 *          )
 *     },
 *     uniqueConstraints={
 *          @UniqueConstraint(
 *              name="uniq_88bdf3e9e7927c74",
 *              columns={"email"}
 *          )
 *     }
 * )
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class AppUser implements UserInterface
{

    public const MIN_PASSWORD_SIZE = 10;
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const ABOUT = 'about';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_API_DEV = 'ROLE_API_DEV';
    public const ID = 'id';
    public const MOBILE_PHONE = 'mobile_phone';
    //TODO: change these values
    public const API_ADMIN_EMAIL = 'root@localhost';
    public const API_ADMIN_NAME = 'App Admin';

    use EntityTrait;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mobilePhone;

    /**
     * @var string
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $about;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * @return string
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @param string $about
     */
    public function setAbout(string $about): void
    {
        $this->about = $about;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @return string
     */
    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $mobilePhone
     */
    public function setMobilePhone(string $mobilePhone): void
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * AppUser constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->createdAt = $this->now();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = json_decode($this->roles, true);
        // guarantee every user at least has ROLE_USER
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = json_encode($roles);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::EMAIL => $this->email,
            self::MOBILE_PHONE => $this->mobilePhone,
            self::ABOUT => $this->about,
            self::FIRST_NAME => $this->firstName,
            self::LAST_NAME => $this->lastName
        ];
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function is(AppUser $userToTest): bool
    {
        return $this->id === $userToTest->id;
    }

    public function hasRole(string $roleToTest)
    {
        return in_array(
            $roleToTest,
            $this->getRoles(),
            true
        );
    }

    public function isApiDev(): bool
    {
        return $this->hasRole(
            self::ROLE_API_DEV
        );
    }
}
