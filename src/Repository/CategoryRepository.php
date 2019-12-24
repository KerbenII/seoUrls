<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * CategoryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param $value
     * @return Category|null
     * @throws NonUniqueResultException
     */
    public function findOneByName($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
