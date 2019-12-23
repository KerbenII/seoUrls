<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Redirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Redirection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Redirection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Redirection[]    findAll()
 * @method Redirection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RedirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redirection::class);
    }

    /**
     * @param $path
     *
     * @return Redirection|null
     * @throws NonUniqueResultException
     */
    public function findRedirectionByPath($path): ?Redirection
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.fromPath = :val')
            ->setParameter('val', $path)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
