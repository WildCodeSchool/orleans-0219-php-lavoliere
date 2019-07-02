<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarRepository")
 */
class Calendar
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
    private $Product;

    /**
     * @ORM\Column(type="date")
     */
    private $seasonStartAt;

    /**
     * @ORM\Column(type="date")
     */
    private $seasonEndAt;

    /**
     * @ORM\Column(type="date")
     */
    private $pickingStartAt;

    /**
     * @ORM\Column(type="date")
     */
    private $pickingEndAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $outOfStock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->Product;
    }

    public function setProduct(string $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getSeasonStartAt(): ?\DateTimeInterface
    {
        return $this->seasonStartAt;
    }

    public function setSeasonStartAt(\DateTimeInterface $seasonStartAt): self
    {
        $this->seasonStartAt = $seasonStartAt;

        return $this;
    }

    public function getSeasonEndAt(): ?\DateTimeInterface
    {
        return $this->seasonEndAt;
    }

    public function setSeasonEndAt(\DateTimeInterface $seasonEndAt): self
    {
        $this->seasonEndAt = $seasonEndAt;

        return $this;
    }

    public function getPickingStartAt(): ?\DateTimeInterface
    {
        return $this->pickingStartAt;
    }

    public function setPickingStartAt(\DateTimeInterface $pickingStartAt): self
    {
        $this->pickingStartAt = $pickingStartAt;

        return $this;
    }

    public function getPickingEndAt(): ?\DateTimeInterface
    {
        return $this->pickingEndAt;
    }

    public function setPickingEndAt(\DateTimeInterface $pickingEndAt): self
    {
        $this->pickingEndAt = $pickingEndAt;

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
}
