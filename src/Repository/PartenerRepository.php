<?php

namespace App\Repository;

use App\Entity\Partener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Partener|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partener|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partener[]    findAll()
 * @method Partener[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partener::class);
    }

    // /**
    //  * @return Partener[] Returns an array of Partener objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partener
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
