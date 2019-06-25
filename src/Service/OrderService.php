<?php


namespace App\Service;

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
}
