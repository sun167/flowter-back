<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\OneToOne(inversedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Car $car = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Ride::class)]
    private Collection $rides;

    #[ORM\OneToMany(mappedBy: 'departurePlace', targetEntity: Ride::class)]
    private Collection $ridesDepartFromThisLocation;

    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: Ride::class)]
    private Collection $ridesComesToThisDestination;

    public function __construct()
    {
        $this->rides = new ArrayCollection();
        $this->ridesDepartFromThisLocation = new ArrayCollection();
        $this->ridesComesToThisDestination = new ArrayCollection();
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
}
