<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(normalizationContext: ['groups' => ['get']])]
#[Get()]
#[Post(
normalizationContext: ['groups' => ['postRead']],
denormalizationContext: ['groups' => ['postWrite']]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['id'], message: 'There is already an account with this id')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get')]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['get', 'postWrite'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['get', 'postWrite'])]
    private ?string $password = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?bool $driverLicenceCheck = null;

    #[ORM\Column]
    #[Groups(['get', 'postWrite'])]
    private ?bool $identityCheck = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?bool $isDriver = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Allowance::class)]
    #[Groups('get')]    
    private Collection $allowances;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups('get')]    
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Maintenance::class)]
    #[Groups('get')]        
    private Collection $maintenances;

    #[ORM\ManyToMany(targetEntity: Ride::class, mappedBy: 'users')]
    #[Groups('get')]    
    private Collection $rides;

    #[ORM\OneToMany(targetEntity: Ride::class, mappedBy: 'driver')]
    #[Groups('get')]            
    private Collection $ridesAsDriver;

    #[ORM\Column(length: 50)]
    #[Groups(['get', 'postWrite'])]
    private ?string $email = null;

    public function __construct()
    {
        $this->allowances = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
        $this->rides = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isDriverLicenseCheck(): ?bool
    {
        return $this->driverLicenceCheck;
    }

    public function setDriverLicenseCheck(?bool $driverLicenceCheck): self
    {
        $this->driverLicenceCheck = $driverLicenceCheck;

        return $this;
    }

    public function isIdentityCheck(): ?bool
    {
        return $this->identityCheck;
    }

    public function setIdentityCheck(bool $identityCheck): self
    {
        $this->identityCheck = $identityCheck;

        return $this;
    }

    public function isIsDriver(): ?bool
    {
        return $this->isDriver;
    }

    public function setIsDriver(?bool $isDriver): self
    {
        $this->isDriver = $isDriver;

        return $this;
    }

    /**
     * @return Collection<int, Allowance>
     */
    public function getAllowances(): Collection
    {
        return $this->allowances;
    }

    public function addAllowance(Allowance $allowance): self
    {
        if (!$this->allowances->contains($allowance)) {
            $this->allowances->add($allowance);
            $allowance->setUser($this);
        }

        return $this;
    }

    public function removeAllowance(Allowance $allowance): self
    {
        if ($this->allowances->removeElement($allowance)) {
            // set the owning side to null (unless already changed)
            if ($allowance->getUser() === $this) {
                $allowance->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRidesAsDriver(): Collection
    {
        return $this->ridesAsDriver;
    }

    public function addRidesAsDriver(Ride $rideAsDriver): self
    {
        if (!$this->ridesAsDriver->contains($rideAsDriver)) {
            $this->ridesAsDriver->add($rideAsDriver);
            $rideAsDriver->setDriver($this);
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Maintenance>
     */
    public function getMaintenances(): Collection
    {
        return $this->maintenances;
    }

    public function addMaintenance(Maintenance $maintenance): self
    {
        if (!$this->maintenances->contains($maintenance)) {
            $this->maintenances->add($maintenance);
            $maintenance->setUser($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): self
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getUser() === $this) {
                $maintenance->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRides(): Collection
    {
        return $this->rides;
    }

    public function addRide(Ride $ride): self
    {
        if (!$this->rides->contains($ride)) {
            $this->rides->add($ride);
            $ride->addUser($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->removeElement($ride)) {
            $ride->removeUser($this);
        }

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }
}
