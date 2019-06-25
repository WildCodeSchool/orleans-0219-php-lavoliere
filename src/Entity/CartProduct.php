<?php


namespace App\Entity;

class CartProduct
{
    /**
     * Quantity
     * @var int
     */
    private $quantity = 1;

    /**
     * Product stocked
     * @var Product
     */
    private $product;

    /**
     * Total
     * @var float
     */
    private $total = 0;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function increment() : void
    {
        $this->quantity++;
    }

    public function decrement() : void
    {
        $this->quantity--;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
