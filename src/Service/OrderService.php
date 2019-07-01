<?php


namespace App\Service;

use App\Entity\Delivery;
use App\Entity\CartProduct;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseProduct;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    private $session;
    private $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function addToCart(Product $product)
    {
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
        $cartProduct = new CartProduct();
        $cart = $this->session->get('cart');
        $cartProduct->setQuantity(1);
        $cartProduct->setProduct($product);
        $cart [$product->getId()] = $cartProduct;
        $this->session->set('cart', $cart);
        return $this->session;
    }

    /**
     * puts in session the delivery chosen by the customer
     * @param Delivery $delivery
     */
    public function setDelivery(Delivery $delivery)
    {
        $this->session->set('delivery', $delivery);
    }

    public function getDelivery(): Delivery
    {
        if (!$this->session->has('delivery')) {
            $this->session->set('delivery', []);
        }
        return $this->session->get('delivery');
    }

    public function getCart(): array
    {
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
        return $this->session->get('cart');
    }

    public function calculateTotalByProduct(): void
    {
        if ($this->session->get('cart')) {
            $cartProducts = $this->session->get('cart');
            foreach ($cartProducts as $cartProduct) {
                $price = $cartProduct->getProduct()->getPrice();
                $quantity = $cartProduct->getQuantity();
                $total = $price * $quantity;
                $cartProduct->setTotal($total);
            }
        }
    }

    public function calculateTotalCart(): float
    {
        if (!empty($this->session->get('cart'))) {
            $cartProducts = $this->session->get('cart');
            $totalCart = 0;
            foreach ($cartProducts as $cartProduct) {
                $totalByProduct = $cartProduct->getTotal();
                $totalCart += $totalByProduct;
            }

            return $totalCart;
        }
    }


    public function calculateTotalProduct(): ?int
    {
        $totalProduct = 0;
        if ($this->session->get('cart')) {
            $cartProducts = $this->session->get('cart');
            $totalProduct = 0;
            foreach ($cartProducts as $cartProduct) {
                $quantityByProduct = $cartProduct->getQuantity();
                $totalProduct += $quantityByProduct;
            }
        }
        return $totalProduct;
    }

    public function calculateTotalPurchase(Purchase $purchase): ?float
    {
        $total = 0;
        $purchaseProducts = $purchase->getPurchaseProducts();
        foreach ($purchaseProducts as $purchaseProduct) {
            $totalProduct = $purchaseProduct->getQuantity() * $purchaseProduct->getPrice();
            $total += $totalProduct;
        }
        return $total;
    }

    public function calculateTotalProductPurchase(Purchase $purchase): ?float
    {
        $totalProduct = 0;
        $purchaseProducts = $purchase->getPurchaseProducts();
        foreach ($purchaseProducts as $purchaseProduct) {
            $quantityByProduct = $purchaseProduct->getQuantity();
            $totalProduct += $quantityByProduct;
        }
        return $totalProduct;
    }

    public function calculateTotalByPurchaseProduct(PurchaseProduct $purchaseProduct): float
    {
        $price = $purchaseProduct->getPrice();
        $quantity = $purchaseProduct->getQuantity();
        $total = $price * $quantity;
        return $total;
    }
}
