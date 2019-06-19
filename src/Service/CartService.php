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

    /**
     * @param Product $product
     * @Route("/add/{id}", name="add_cart", methods={"POST", "GET"})
     */
    public function addToCart(Product $product)
    {
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
        $cart = $this->session->get('cart');
        if (array_key_exists($product->getId(), $cart)) {
            ++$cart[$product->getId()]['quantity'] ;
        } else {
            $cart[$product->getId()] = [
                'quantity' => 1,
                'product' => $this->productRepository->find($product->getId())
            ];
        }
        $this->session->set('cart', $cart);
        return $this->session;
    }
}
