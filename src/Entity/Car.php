<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $motDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $insuranceDate = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $licensePlate = null;

    #[ORM\Column(nullable: true)]
    private ?float $mileage = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Model $model = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Maintenance::class)]
    private Collection $maintenances;

    #[ORM\OneToOne(mappedBy: 'car', cascade: ['persist', 'remove'])]
    private ?Location $location = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Ride::class)]
    private Collection $rides;

    #[ORM\ManyToMany(targetEntity: Option::class, mappedBy: 'cars')]
    private Collection $options;

    public function __construct()
    {
        $this->maintenances = new ArrayCollection();
        $this->rides = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotDate(): ?\DateTimeInterface
    {
        return $this->motDate;
    }

    public function setMotDate(?\DateTimeInterface $motDate): self
    {
        $this->motDate = $motDate;

        return $this;
    }

    public function getInsuranceDate(): ?\DateTimeInterface
    {
        return $this->insuranceDate;
    }

    public function setInsuranceDate(?\DateTimeInterface $insuranceDate): self
    {
        $this->insuranceDate = $insuranceDate;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getMileage(): ?float
    {
        return $this->mileage;
    }

    public function setMileage(?float $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

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
            $maintenance->setCar($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): self
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getCar() === $this) {
                $maintenance->setCar(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        // unset the owning side of the relation if necessary
        if ($location === null && $this->location !== null) {
            $this->location->setCar(null);
        }

        // set the owning side of the relation if necessary
        if ($location !== null && $location->getCar() !== $this) {
            $location->setCar($this);
        }

        $this->location = $location;

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
            $ride->setCar($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->removeElement($ride)) {
            // set the owning side to null (unless already changed)
            if ($ride->getCar() === $this) {
                $ride->setCar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->addCar($this);
        }

        return $this;
    }

    public function removeOption(Option $option): static
    {
        if ($this->options->removeElement($option)) {
            $option->removeCar($this);
        }

        return $this;
    }
}
