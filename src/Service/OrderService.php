<?php


namespace App\Service;

use App\Entity\Delivery;
use App\Entity\Location;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * puts in session the delivery chosen by the customer
     * @param Delivery $delivery
     */
    public function setDelivery(Delivery $delivery)
    {
        $this->session->set('delivery', $delivery);
    }

    public function getDelivery() : Delivery
    {
        return $this->session->get('delivery');
    }
}
