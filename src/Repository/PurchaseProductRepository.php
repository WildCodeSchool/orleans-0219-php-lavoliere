<?php

namespace App\Repository;

use App\Entity\PurchaseProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PurchaseProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseProduct[]    findAll()
 * @method PurchaseProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PurchaseProduct::class);
    }
}
