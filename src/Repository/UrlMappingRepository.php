<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Redirection;
use App\Entity\UrlMapping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\NonUniqueResultException;
use Throwable;

/**
 * @method UrlMapping|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlMapping|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlMapping[]    findAll()
 * @method UrlMapping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlMappingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlMapping::class);
    }

    /**
     * @param $path
     *
     * @return UrlMapping|null
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

    /**
     * @param string $controller
     * @param string $method
     * @param int $id
     * @return mixed
     * @throws NonUniqueResultException
     */
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
     * @throws Throwable
     */
    public function createOrUpdateAndRedirect($newUrlMapping): void
    {
        $em = $this->getEntityManager();

        /* @var UrlMapping $newUrlMapping */
        $em->transactional(function () use ($newUrlMapping, $em) {
            // Use pessimistic write lock when selecting, it will revert once errored.
            /** @var UrlMapping $mapping */
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
                $mapping = $mapping[0];
                if ($newUrlMapping->getPath() === $mapping->getPath()) {
                    return;
                }
                $redirection = new Redirection();
                $redirection->setFromPath($mapping->getPath());
                $redirection->setToPath($newUrlMapping->getPath());
                $redirection->setStatusCode(301);

                $em->persist($redirection);
            }
            $em->persist($newUrlMapping);
        });
    }
}
