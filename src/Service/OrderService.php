<?php


namespace App\Service;

use App\Entity\Delivery;
use App\Entity\CartProduct;
use App\Entity\Product;
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
        $cart = $this->session->get('cart');

        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()]->increment();
        } else {
            $cartProduct = new CartProduct();
            $cartProduct->setProduct($product);
            $cart[$product->getId()] = $cartProduct;
        }
        $this->session->set('cart', $cart);
        return $this->session;
    }

    public function increaseCart(CartProduct $cartProduct)
    {
        $cart = $this->session->get('cart');
        if ($cartProduct->getQuantity() < 50) {
            $cartProduct->increment();
        }
        $this->session->set('cart', $cart);
        return $this->session;
    }

    public function decreaseCart(CartProduct $cartProduct)
    {
        $cart = $this->session->get('cart');
        if ($cartProduct->getQuantity() > 1) {
            $cartProduct->decrement();
        }
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
        return $this->session->get('delivery');
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
}
