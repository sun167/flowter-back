<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(normalizationContext: ['groups' => ['get']])]
#[Get()]
#[Post(
normalizationContext: ['groups' => ['postRead']],
denormalizationContext: ['groups' => ['postWrite']]
)]
#[GetCollection()]
#[ApiFilter(DateFilter::class, properties: [
'car.rides.dateOfLoan'
])]
#[ApiFilter(DateFilter::class, properties: [
'car.rides.dateOfReturn'
])]
#[ApiFilter(SearchFilter::class, properties: [
'car.location.name' => 'iexact'
])]
#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?\DateTimeInterface $motDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?\DateTimeInterface $insuranceDate = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['get', 'postWrite'])]
    private ?string $licensePlate = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    // #[Groups('get')]
    private ?Model $model = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    // #[Groups('get')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Maintenance::class)]
    // #[Groups('get')]
    private Collection $maintenances;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Ride::class)]
    // #[Groups('get')]
    private Collection $rides;

    #[ORM\ManyToMany(targetEntity: Option::class, mappedBy: 'cars')]
    // #[Groups('get')]
    private Collection $options;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    // #[Groups('get')]
    private ?Location $location = null;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
