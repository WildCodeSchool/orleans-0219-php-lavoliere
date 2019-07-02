<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarRepository")
 */
class PickingCalendar
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
    private $product;


    /**
     * @ORM\Column(type="boolean")
     */
    private $outOfStock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="seasonStartAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seasonStartAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="seasonEndAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seasonEndAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="pickingStartAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickingStartAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="pickingEndAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickingEndAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOutOfStock(): ?bool
    {
        return $this->outOfStock;
    }

    public function setOutOfStock(bool $outOfStock): self
    {
        $this->outOfStock = $outOfStock;

        return $this;
    }

    public function getSeasonStartAt(): ?MonthCalendar
    {
        return $this->seasonStartAt;
    }

    public function setSeasonStartAt(?MonthCalendar $seasonStartAt): self
    {
        $this->seasonStartAt = $seasonStartAt;

        return $this;
    }

    public function getSeasonEndAt(): ?MonthCalendar
    {
        return $this->seasonEndAt;
    }

    public function setSeasonEndAt(?MonthCalendar $seasonEndAt): self
    {
        $this->seasonEndAt = $seasonEndAt;

        return $this;
    }

    public function getPickingStartAt(): ?MonthCalendar
    {
        return $this->pickingStartAt;
    }

    public function setPickingStartAt(?MonthCalendar $pickingStartAt): self
    {
        $this->pickingStartAt = $pickingStartAt;

        return $this;
    }

    public function getPickingEndAt(): ?MonthCalendar
    {
        return $this->pickingEndAt;
    }

    public function setPickingEndAt(?MonthCalendar $pickingEndAt): self
    {
        $this->pickingEndAt = $pickingEndAt;

        return $this;
    }
}
