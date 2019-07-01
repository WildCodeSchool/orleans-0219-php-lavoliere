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

    const CART_SESSION_KEY = 'cart';

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function addToCart(Product $product)
    {
        $cart = $this->getCart();
        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()]->increment();
        } else {
            $cartProduct = new CartProduct();
            $cartProduct->setProduct($product);
            $cart[$product->getId()] = $cartProduct;
        }
        $this->setCart($cart);
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


    public function setCart($cart)
    {
        $this->session->set(self::CART_SESSION_KEY, $cart);
    }

    public function getCart()
    {
        if (empty($this->session->get(self::CART_SESSION_KEY))) {
            $cart = [];
            $this->session->set(self::CART_SESSION_KEY, $cart);
        }
        return $this->session->get(self::CART_SESSION_KEY);
    }

    public function getTotalCart(): float
    {
        $totalCart = 0;
        $cartProducts = $this->getCart();

        if ($cartProducts) {
            foreach ($cartProducts as $cartProduct) {
                $totalCart += $cartProduct->getTotal();
            }
        }
        return $totalCart;
    }

    public function getTotalProduct(): int
    {
        $totalProduct = 0;
        $cartProducts = $this->getCart();

        if ($cartProducts) {
            foreach ($cartProducts as $cartProduct) {
                $totalProduct += $cartProduct->getQuantity();
            }
        }
        return $totalProduct;
    }

    public function getTotalPurchase(Purchase $purchase): ?float
    {
        $total = 0;
        $purchaseProducts = $purchase->getPurchaseProducts();
        foreach ($purchaseProducts as $purchaseProduct) {
            $totalProduct = $purchaseProduct->getQuantity() * $purchaseProduct->getPrice();
            $total += $totalProduct;
        }
        return $total;
    }

    public function getTotalProductPurchase(Purchase $purchase): ?float
    {
        $totalProduct = 0;
        $purchaseProducts = $purchase->getPurchaseProducts();
        foreach ($purchaseProducts as $purchaseProduct) {
            $quantityByProduct = $purchaseProduct->getQuantity();
            $totalProduct += $quantityByProduct;
        }
        return $totalProduct;
    }

    public function getTotalByPurchaseProduct(PurchaseProduct $purchaseProduct): float
    {
        $price = $purchaseProduct->getPrice();
        $quantity = $purchaseProduct->getQuantity();
        $total = $price * $quantity;
        return $total;
    }
}
