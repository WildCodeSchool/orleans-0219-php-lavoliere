<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PickingCalendarRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="productsSeasonStartAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seasonStartAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="productsSeasonEndAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seasonEndAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="productsPickingStartAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickingStartAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthCalendar", inversedBy="productsPickingEndAt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickingEndAt;

    const MONTHS = [
        '1' => 'Janvier',
        '2' => 'Février',
        '3' => 'Mars',
        '4' => 'Avril',
        '5' => 'Mai',
        '6' => 'Juin',
        '7' => 'Juillet',
        '8' => 'Aout',
        '9' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre',
    ];

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

    public function getSeasonDateArray(): array
    {

        $seasonStartAt = $this->seasonStartAt->getMonth();
        $seasonEndAt = $this->seasonEndAt->getMonth();

        $seasonDateArray = self::getDateArray($seasonStartAt, $seasonEndAt);

        return $seasonDateArray;
    }

    public function getPickingDateArray(): array
    {
        $pickingStartAt = $this->pickingStartAt->getMonth();
        $pickingEndAt = $this->pickingEndAt->getMonth();

        $pickingDateArray = self::getDateArray($pickingStartAt, $pickingEndAt);

        return $pickingDateArray;
    }

    public function getDateArray($calendarStartAt, $calendarEndAt) : array
    {
        $months = self::MONTHS;
        $start = array_keys($months, $calendarStartAt);
        $startAt = intval(implode($start));
        $end = array_keys($months, $calendarEndAt);
        $endAt = intval(implode($end));

        $pickingDateArray = array_fill(1, 12, false);

        if ($startAt === $endAt) {
            $pickingDateArray[$startAt] = true;
            return $pickingDateArray;
        }

        if ($startAt < $endAt) {
            for ($i = $startAt; $i <= $endAt; $i++) {
                $pickingDateArray[$i] = true;
            }
            return $pickingDateArray;
        }


        $pickingDateArray = array_fill(1, 12, true);

        for ($j = $startAt-1; $j >= $endAt+1; $j--) {
            $pickingDateArray[$j] = false;
        }

        return $pickingDateArray;
    }
}
