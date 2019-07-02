<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthCalendarRepository")
 */
class MonthCalendar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $month;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PickingCalendar", mappedBy="seasonStartAt")
     */
    private $productsSeasonStartAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PickingCalendar", mappedBy="seasonEndAt")
     */
    private $productsSeasonEndAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PickingCalendar", mappedBy="pickingStartAt")
     */
    private $productsPickingStartAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PickingCalendar", mappedBy="pickingEndAt")
     */
    private $productsPickingEndAt;

    public function __construct()
    {
        $this->productsSeasonStartAt = new ArrayCollection();
        $this->productsSeasonEndAt = new ArrayCollection();
        $this->productsPickingStartAt = new ArrayCollection();
        $this->productsPickingEndAt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return Collection|PickingCalendar[]
     */
    public function getProductsSeasonStartAt(): Collection
    {
        return $this->productsSeasonStartAt;
    }

    public function addProductsSeasonStartAt(PickingCalendar $seasonStartAt): self
    {
        if (!$this->productsSeasonStartAt->contains($seasonStartAt)) {
            $this->productsSeasonStartAt[] = $seasonStartAt;
            $seasonStartAt->setSeasonStartAt($this);
        }

        return $this;
    }

    public function removeProductsSeasonStartAt(PickingCalendar $seasonStartAt): self
    {
        if ($this->productsSeasonStartAt->contains($seasonStartAt)) {
            $this->productsSeasonStartAt->removeElement($seasonStartAt);
            // set the owning side to null (unless already changed)
            if ($seasonStartAt->getSeasonStartAt() === $this) {
                $seasonStartAt->setSeasonStartAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PickingCalendar[]
     */
    public function getProductsSeasonEndAt(): Collection
    {
        return $this->productsSeasonEndAt;
    }

    public function addProductsSeasonEndAt(PickingCalendar $seasonEndAt): self
    {
        if (!$this->productsSeasonEndAt->contains($seasonEndAt)) {
            $this->productsSeasonEndAt[] = $seasonEndAt;
            $seasonEndAt->setSeasonEndAt($this);
        }

        return $this;
    }

    public function removeProductsSeasonEndAt(PickingCalendar $seasonEndAt): self
    {
        if ($this->productsSeasonEndAt->contains($seasonEndAt)) {
            $this->productsSeasonEndAt->removeElement($seasonEndAt);
            // set the owning side to null (unless already changed)
            if ($seasonEndAt->getSeasonEndAt() === $this) {
                $seasonEndAt->setSeasonEndAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PickingCalendar[]
     */
    public function getProductsPickingStartAt(): Collection
    {
        return $this->productsPickingStartAt;
    }

    public function addProductsPickingStartAt(PickingCalendar $pickingStartAt): self
    {
        if (!$this->productsPickingStartAt->contains($pickingStartAt)) {
            $this->productsPickingStartAt[] = $pickingStartAt;
            $pickingStartAt->setPickingStartAt($this);
        }

        return $this;
    }

    public function removeProductsPickingStartAt(PickingCalendar $pickingStartAt): self
    {
        if ($this->productsPickingStartAt->contains($pickingStartAt)) {
            $this->productsPickingStartAt->removeElement($pickingStartAt);
            // set the owning side to null (unless already changed)
            if ($pickingStartAt->getPickingStartAt() === $this) {
                $pickingStartAt->setPickingStartAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PickingCalendar[]
     */
    public function getProductsPickingEndAt(): Collection
    {
        return $this->productsPickingEndAt;
    }

    public function addProductsPickingEndAt(PickingCalendar $pickingEndAt): self
    {
        if (!$this->productsPickingEndAt->contains($pickingEndAt)) {
            $this->productsPickingEndAt[] = $pickingEndAt;
            $pickingEndAt->setPickingEndAt($this);
        }

        return $this;
    }

    public function removeProductsPickingEndAt(PickingCalendar $pickingEndAt): self
    {
        if ($this->productsPickingEndAt->contains($pickingEndAt)) {
            $this->productsPickingEndAt->removeElement($pickingEndAt);
            // set the owning side to null (unless already changed)
            if ($pickingEndAt->getPickingEndAt() === $this) {
                $pickingEndAt->setPickingEndAt(null);
            }
        }

        return $this;
    }
}
