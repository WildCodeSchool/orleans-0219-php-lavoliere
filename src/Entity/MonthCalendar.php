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
     * @ORM\OneToMany(targetEntity="App\Entity\Calendar", mappedBy="seasonStartAt")
     */
    private $seasonStartAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calendar", mappedBy="seasonEndAt")
     */
    private $seasonEndAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calendar", mappedBy="pickingStartAt")
     */
    private $pickingStartAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calendar", mappedBy="pickingEndAt")
     */
    private $pickingEndAt;

    public function __construct()
    {
        $this->seasonStartAt = new ArrayCollection();
        $this->seasonEndAt = new ArrayCollection();
        $this->pickingStartAt = new ArrayCollection();
        $this->pickingEndAt = new ArrayCollection();
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
     * @return Collection|Calendar[]
     */
    public function getSeasonStartAt(): Collection
    {
        return $this->seasonStartAt;
    }

    public function addSeasonStartAt(Calendar $seasonStartAt): self
    {
        if (!$this->seasonStartAt->contains($seasonStartAt)) {
            $this->seasonStartAt[] = $seasonStartAt;
            $seasonStartAt->setSeasonStartAt($this);
        }

        return $this;
    }

    public function removeSeasonStartAt(Calendar $seasonStartAt): self
    {
        if ($this->seasonStartAt->contains($seasonStartAt)) {
            $this->seasonStartAt->removeElement($seasonStartAt);
            // set the owning side to null (unless already changed)
            if ($seasonStartAt->getSeasonStartAt() === $this) {
                $seasonStartAt->setSeasonStartAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getSeasonEndAt(): Collection
    {
        return $this->seasonEndAt;
    }

    public function addSeasonEndAt(Calendar $seasonEndAt): self
    {
        if (!$this->seasonEndAt->contains($seasonEndAt)) {
            $this->seasonEndAt[] = $seasonEndAt;
            $seasonEndAt->setSeasonEndAt($this);
        }

        return $this;
    }

    public function removeSeasonEndAt(Calendar $seasonEndAt): self
    {
        if ($this->seasonEndAt->contains($seasonEndAt)) {
            $this->seasonEndAt->removeElement($seasonEndAt);
            // set the owning side to null (unless already changed)
            if ($seasonEndAt->getSeasonEndAt() === $this) {
                $seasonEndAt->setSeasonEndAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getPickingStartAt(): Collection
    {
        return $this->pickingStartAt;
    }

    public function addPickingStartAt(Calendar $pickingStartAt): self
    {
        if (!$this->pickingStartAt->contains($pickingStartAt)) {
            $this->pickingStartAt[] = $pickingStartAt;
            $pickingStartAt->setPickingStartAt($this);
        }

        return $this;
    }

    public function removePickingStartAt(Calendar $pickingStartAt): self
    {
        if ($this->pickingStartAt->contains($pickingStartAt)) {
            $this->pickingStartAt->removeElement($pickingStartAt);
            // set the owning side to null (unless already changed)
            if ($pickingStartAt->getPickingStartAt() === $this) {
                $pickingStartAt->setPickingStartAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getPickingEndAt(): Collection
    {
        return $this->pickingEndAt;
    }

    public function addPickingEndAt(Calendar $pickingEndAt): self
    {
        if (!$this->pickingEndAt->contains($pickingEndAt)) {
            $this->pickingEndAt[] = $pickingEndAt;
            $pickingEndAt->setPickingEndAt($this);
        }

        return $this;
    }

    public function removePickingEndAt(Calendar $pickingEndAt): self
    {
        if ($this->pickingEndAt->contains($pickingEndAt)) {
            $this->pickingEndAt->removeElement($pickingEndAt);
            // set the owning side to null (unless already changed)
            if ($pickingEndAt->getPickingEndAt() === $this) {
                $pickingEndAt->setPickingEndAt(null);
            }
        }

        return $this;
    }
}
