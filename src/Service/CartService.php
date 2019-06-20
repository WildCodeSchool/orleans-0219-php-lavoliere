<?php


namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
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
        $product->setQuantity(1);
        $cart = $this->session->get('cart');
        $cart[$product->getId()] = [
            'product' => $this->productRepository->find($product->getId())
        ];
        $this->session->set('cart', $cart);
        return $this->session;
    }
}
