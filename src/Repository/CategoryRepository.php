<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{

    public $basketCategory;


    public function __construct(RegistryInterface $registry, ParameterBagInterface $params)
    {
        parent::__construct($registry, Category::class);

        $this->basketCategory = $params->get('basket_category');
    }

    public function findByAllExceptBasket()
    {

        $query = $this->createQueryBuilder('c')
            ->andWhere('c.name != :basket')
            ->setParameter('basket', $this->basketCategory)
            ->getQuery();

        return $query->execute();
    }
}
