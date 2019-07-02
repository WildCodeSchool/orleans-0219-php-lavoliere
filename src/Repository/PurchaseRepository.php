<?php

namespace App\Repository;

use App\Entity\Purchase;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use DoctrineExtensions\Query\Mysql\Date;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function findAllByDescDate()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.deliveryDate', 'DESC')
            ->getQuery();
        return $qb->execute();
    }

    /**
     * @param User $user
     * @return array
     */
    public function findPurchasesByDescOrderDate(User $user): array
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.User = :user')
            ->setParameter('user', $user)
            ->orderBy('p.orderDate', 'DESC')
            ->getQuery();
        return $qb->execute();
    }

    public function findPurchasesByDateInterval(\DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->createQueryBuilder('p')
            ->Where('p.deliveryDate >= :startDate')
            ->andWhere('p.deliveryDate <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('p.deliveryDate', 'ASC')
            ->getQuery();
        return $qb->execute();
    }

    public function findByActualDayPurchases(): array
    {
        $now = new \DateTime();
        $now = $now->format('Y-m-d');

        $qb = $this->createQueryBuilder('p')
            ->where('p.deliveryDate = :now')
            ->setParameter('now', $now)
            ->orderBy('p.location')
            ->getQuery();

        return $qb->execute();
    }
}
