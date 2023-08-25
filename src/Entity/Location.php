<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(normalizationContext: ['groups' => ['get']])]
#[Get]
#[Post(
normalizationContext: ['groups' => ['postRead']],
denormalizationContext: ['groups' => ['postWrite']]
)]
#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get')]
    private ?int $id = null;

    #[Groups(['get', 'postWrite'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[Groups(['get', 'postWrite'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[Groups('get')]
    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Ride::class)]
    private Collection $rides;
    #[Groups('get')]
    #[ORM\OneToMany(mappedBy: 'departurePlace', targetEntity: Ride::class)]
    private Collection $ridesDepartFromThisLocation;

    #[Groups('get')]
    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: Ride::class)]
    private Collection $ridesComesToThisDestination;

    #[Groups('get')]
    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Car::class)]
    private Collection $cars;

    public function __construct()
    {
        $this->rides = new ArrayCollection();
        $this->ridesDepartFromThisLocation = new ArrayCollection();
        $this->ridesComesToThisDestination = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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
            $ride->setLocation($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->removeElement($ride)) {
            // set the owning side to null (unless already changed)
            if ($ride->getLocation() === $this) {
                $ride->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRidesDepartFromThisLocation(): Collection
    {
        return $this->ridesDepartFromThisLocation;
    }

    public function addRidesDepartFromThisLocation(Ride $ridesDepartFromThisLocation): static
    {
        if (!$this->ridesDepartFromThisLocation->contains($ridesDepartFromThisLocation)) {
            $this->ridesDepartFromThisLocation->add($ridesDepartFromThisLocation);
            $ridesDepartFromThisLocation->setDeparturePlace($this);
        }

        return $this;
    }

    public function removeRidesDepartFromThisLocation(Ride $ridesDepartFromThisLocation): static
    {
        if ($this->ridesDepartFromThisLocation->removeElement($ridesDepartFromThisLocation)) {
            // set the owning side to null (unless already changed)
            if ($ridesDepartFromThisLocation->getDeparturePlace() === $this) {
                $ridesDepartFromThisLocation->setDeparturePlace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRidesComesToThisDestination(): Collection
    {
        return $this->ridesComesToThisDestination;
    }

    public function addRidesComesToThisDestination(Ride $ridesComesToThisDestination): static
    {
        if (!$this->ridesComesToThisDestination->contains($ridesComesToThisDestination)) {
            $this->ridesComesToThisDestination->add($ridesComesToThisDestination);
            $ridesComesToThisDestination->setDestination($this);
        }

        return $this;
    }

    public function removeRidesComesToThisDestination(Ride $ridesComesToThisDestination): static
    {
        if ($this->ridesComesToThisDestination->removeElement($ridesComesToThisDestination)) {
            // set the owning side to null (unless already changed)
            if ($ridesComesToThisDestination->getDestination() === $this) {
                $ridesComesToThisDestination->setDestination(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setLocation($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getLocation() === $this) {
                $car->setLocation(null);
            }
        }

        return $this;
    }
}
