<?php

namespace App\Entity;

use App\Repository\RideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RideRepository::class)]
class Ride
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfLoan = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfReturn = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $realDateOfLoan = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $realDateOfReturn = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbOfSeats = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rides')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}