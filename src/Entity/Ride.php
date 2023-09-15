<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\RideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource]
#[Get()]
#[GetCollection(uriTemplate: '/companies/{companyId}/users', itemUriTemplate: '/companies/{companyId}/users/{id}'/*, ... */)]
#[Post(
normalizationContext: ['groups' => ['postRead']],
denormalizationContext: ['groups' => ['postWrite']]
)]

#[ORM\Entity(repositoryClass: RideRepository::class)]
class Ride
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get', 'postWrite'])]
    private ?\DateTimeInterface $dateOfLoan = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get', 'postWrite'])]
    private ?\DateTimeInterface $dateOfReturn = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('get')]
    private ?\DateTimeInterface $realDateOfLoan = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('get')]
    private ?\DateTimeInterface $realDateOfReturn = null;

    #[ORM\Column(nullable: true)]
    #[Groups('get')]
    private ?int $nbOfSeats = null;

    // Users are passengers
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rides')]
    #[Groups(['get', 'postWrite'])]
    private Collection $users;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ridesAsDriver')]
    #[Groups('get')]
    private User $driver;

    #[ORM\ManyToOne(inversedBy: 'rides')]
    #[Groups('get')]
    private ?Car $car = null;

    #[ORM\OneToMany(mappedBy: 'ride', targetEntity: Incident::class)]
    #[Groups('get')]
    private Collection $incidents;

    #[ORM\ManyToOne(inversedBy: 'rides')]
    #[Groups('get')]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'ridesDepartFromThisLocation')]
    #[Groups(['get', 'postWrite'])]
    private ?Location $departurePlace = null;

    #[ORM\ManyToOne(inversedBy: 'rides')]
    #[Groups(['get', 'postWrite'])]
    private ?Motive $motive = null;

    #[ORM\Column(nullable: true)]
    private ?float $mileageBefore = null;

    #[ORM\Column(nullable: true)]
    private ?float $mileageAfter = null;

    #[ORM\ManyToOne(inversedBy: 'rides')]
    private ?Destination $destination = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->incidents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfLoan(): ?\DateTimeInterface
    {
        return $this->dateOfLoan;
    }

    public function setDateOfLoan(\DateTimeInterface $dateOfLoan): self
    {
        $this->dateOfLoan = $dateOfLoan;

        return $this;
    }

    public function getDateOfReturn(): ?\DateTimeInterface
    {
        return $this->dateOfReturn;
    }

    public function setDateOfReturn(\DateTimeInterface $dateOfReturn): self
    {
        $this->dateOfReturn = $dateOfReturn;

        return $this;
    }

    public function getRealDateOfLoan(): ?\DateTimeInterface
    {
        return $this->realDateOfLoan;
    }

    public function setRealDateOfLoan(?\DateTimeInterface $realDateOfLoan): self
    {
        $this->realDateOfLoan = $realDateOfLoan;

        return $this;
    }

    public function getRealDateOfReturn(): ?\DateTimeInterface
    {
        return $this->realDateOfReturn;
    }

    public function setRealDateOfReturn(?\DateTimeInterface $realDateOfReturn): self
    {
        $this->realDateOfReturn = $realDateOfReturn;

        return $this;
    }

    public function getNbOfSeats(): ?int
    {
        return $this->nbOfSeats;
    }

    public function setNbOfSeats(?int $nbOfSeats): self
    {
        $this->nbOfSeats = $nbOfSeats;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(User $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }


    /**
     * @return Collection<int, Incident>
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): self
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents->add($incident);
            $incident->setRide($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): self
    {
        if ($this->incidents->removeElement($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getRide() === $this) {
                $incident->setRide(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDeparturePlace(): ?Location
    {
        return $this->departurePlace;
    }

    public function setDeparturePlace(?Location $departurePlace): static
    {
        $this->departurePlace = $departurePlace;

        return $this;
    }

    public function getMotive(): ?Motive
    {
        return $this->motive;
    }

    public function setMotive(?Motive $motive): static
    {
        $this->motive = $motive;

        return $this;
    }

    public function getMileageBefore(): ?float
    {
        return $this->mileageBefore;
    }

    public function setMileageBefore(?float $mileageBefore): static
    {
        $this->mileageBefore = $mileageBefore;

        return $this;
    }

    public function getMileageAfter(): ?float
    {
        return $this->mileageAfter;
    }

    public function setMileageAfter(?float $mileageAfter): static
    {
        $this->mileageAfter = $mileageAfter;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): static
    {
        $this->destination = $destination;

        return $this;
    }
}
