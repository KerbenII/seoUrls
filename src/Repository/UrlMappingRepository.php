<?php

declare(strict_types=1);

namespace App\Repository;

use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Entity\Redirection;
use App\Entity\UrlMapping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method UrlMapping|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlMapping|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlMapping[]    findAll()
 * @method UrlMapping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlMappingRepository extends ServiceEntityRepository
{
    const TYPE_PRODUCT = ProductController::class;
    const TYPE_CATEGORY = CategoryController::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlMapping::class);
    }

    /**
     * @param $path
     *
     * @throws NonUniqueResultException
     */
    public function findUrlMappingByPath($path): ?UrlMapping
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.path = :val')
            ->setParameter('val', $path)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPathForMapping(string $controller, string $method, int $id)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.controller = :controller')
            ->setParameter('controller', $controller)
            ->andWhere('u.method = :method')
            ->setParameter('method', $method)
            ->andWhere('u.identifier = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $newUrlMapping
     * @throws \Throwable
     */
    public function createOrUpdateAndRedirect($newUrlMapping): void
    {
        $em = $this->getEntityManager();

        /* @var UrlMapping $newUrlMapping */
        $em->transactional(function () use ($newUrlMapping, $em) {
            // Use pessimistic write lock when selecting.
            $mapping = $this->createQueryBuilder('u')
                ->andWhere('u.controller = :controller')
                ->setParameter('controller', $newUrlMapping->getController())
                ->andWhere('u.method = :method')
                ->setParameter('method', $newUrlMapping->getMethod())
                ->andWhere('u.identifier = :identifier')
                ->setParameter('identifier', $newUrlMapping->getIdentifier())
                ->getQuery()
                ->setLockMode(LockMode::PESSIMISTIC_WRITE)
                ->getResult();

            if ($mapping) {
                if ($newUrlMapping->getPath() === $mapping[0]->getPath()) {
                    return;
                }
                $redirection = new Redirection();
                $redirection->setFromPath($mapping[0]->getPath());
                $redirection->setToPath($newUrlMapping->getPath());
                $redirection->setStatusCode(301);

                $em->persist($redirection);
            }
            $em->persist($newUrlMapping);
        });
    }
}
