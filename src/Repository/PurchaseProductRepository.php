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

    public function findAllOrderByName()
    {
        $qb = $this->createQueryBuilder('purchase_product')
            ->orderBy('purchase_product.name')
            ->getQuery();
        return $qb->execute();
    }

    public function findAllGroupByNameWithCountAtActualDay()
    {
        $now = new \DateTime();
        $now = $now->format('Y-m-d');

        $qb = $this->createQueryBuilder('purchase_product')
            ->leftJoin('purchase_product.purchase', 'purchase')
            ->where('purchase.deliveryDate = :now')
            ->setParameter('now', $now)
            ->select('purchase_product.name')
            ->addSelect('SUM(purchase_product.quantity) as nb_products')
            ->groupBy('purchase_product.name')
            ->getQuery();
        return $qb->execute();
    }

    public function findAllGroupByNameWithCountByDateInterval(\DateTime $startDate, \DateTime $endDate)
    {

        $qb = $this->createQueryBuilder('purchase_product')
            ->leftJoin('purchase_product.purchase', 'purchase')
            ->Where('purchase.deliveryDate >= :startDate')
            ->andWhere('purchase.deliveryDate <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->select('purchase_product.name')
            ->addSelect('SUM(purchase_product.quantity) as nb_products')
            ->groupBy('purchase_product.name')
            ->getQuery();
        return $qb->execute();
    }
}
