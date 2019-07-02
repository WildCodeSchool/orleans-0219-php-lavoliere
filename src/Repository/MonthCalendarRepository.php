<?php

namespace App\Repository;

use App\Entity\MonthCalendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MonthCalendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthCalendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthCalendar[]    findAll()
 * @method MonthCalendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthCalendarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MonthCalendar::class);
    }
}
