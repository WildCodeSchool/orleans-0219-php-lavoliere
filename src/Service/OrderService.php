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
        $cartProduct = new CartProduct();
        $cart = $this->session->get('cart');
        $cartProduct->setQuantity(1);
        $cartProduct->setProduct($product);
        $cart[$product->getId()] = ['cartProduct' => $cartProduct];
        $this->session->set('cart', $cart);
        return $this->session;
    }
}
