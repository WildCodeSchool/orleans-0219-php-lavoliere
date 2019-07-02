<?php

namespace App\Repository;

use App\Entity\PickingCalendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PickingCalendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method PickingCalendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method PickingCalendar[]    findAll()
 * @method PickingCalendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PickingCalendar::class);
    }

    public function findAllSortByName()
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.product')
            ->getQuery();

        return $query->execute();
    }
}
