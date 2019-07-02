<?php

namespace App\Repository;

use App\Entity\Partners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Partners|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partners|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partners[]    findAll()
 * @method Partners[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partners::class);
    }
}
