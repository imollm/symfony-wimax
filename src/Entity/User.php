<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D649E7927C74", columns={"email"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649F85E0677", columns={"username"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649444F97DD", columns={"phone"})})
 */
class User implements UserInterface, JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Your surname must be at least {{ limit }} characters long",
     *      maxMessage = "Your surname cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     */
    private string $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=true)
     */
    private string $role;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=false)
     * @Assert\Length(
     *      min = 12,
     *      max = 12,
     *      minMessage = "Your phone number must be {{ limit }} numbers",
     *      maxMessage = "Your phone number must be {{ limit }} numbers",
     *      allowEmptyString = false
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=true,
     *     message="Your phone cannot contain letters"
     * )
     */
    private string $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Your address cannot have more than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private string $address;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private string $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
    * @Assert\Length(
     *      min = 8,
     *      max = 16,
     *      minMessage = "Password must be at least {{ limit }} characters long",
     *      maxMessage = "Password cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Assert\Regex(
     *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/",
     *     match=true,
     *     message="Your password must be at least, one uppercase letter, one lowercase letter, one number and one special character"
     * )
     */
    private string $password;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private DateTime $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private DateTime $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private bool $isActive;

    /**
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="user")
     */
    private $payments;

    /**
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity=Antenna::class, mappedBy="user")
     */
    private $antennas;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->antennas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAntennas()
    {
        return $this->antennas;
    }

    public function setAntennas($antennas): User
    {
        $this->antennas = $antennas;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles(): array
    {
        return array($this->getRole());
    }

    public function eraseCredentials()
    {
        
    }

    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'surname'=>$this->surname,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'role'=>$this->role
        ];
    }
}
