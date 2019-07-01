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

    public function findByActualDayPurchases(): array
    {
        $now = new \DateTime('2019-07-01');
        $now = $now->format('Y-m-d');

        $qb = $this->createQueryBuilder('p')
            ->where('p.deliveryDate = :now')
            ->setParameter('now', '2019-07-13')
            ->orderBy('p.location')
            ->getQuery();

        return $qb->execute();
    }
}
