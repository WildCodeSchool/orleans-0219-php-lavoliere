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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function increment(): void
    {
        if ($this->quantity < 50) {
            $this->quantity++;
        }
    }

    public function decrement(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
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
        return $this->product->getPrice() * $this->getQuantity();
    }

    public function toPurchaseProduct(): PurchaseProduct
    {
        $purchaseProduct = new PurchaseProduct();
        $purchaseProduct->setQuantity($this->getQuantity());
        $purchaseProduct->setName($this->getProduct()->getName());
        $purchaseProduct->setPrice($this->getProduct()->getPrice());
        $purchaseProduct->setBundle($this->getProduct()->getBundle());

        return $purchaseProduct;
    }
}
