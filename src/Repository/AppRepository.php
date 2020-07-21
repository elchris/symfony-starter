<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method  find($id, $lockMode = null, $lockVersion = null)
 * @method  findOneBy(array $criteria, array $orderBy = null)
 * @method  findAll()
 * @method  findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AppRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    protected $manager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntity());
        $this->manager = $this->getEntityManager();
    }

    abstract protected function getEntity(): string;

    /**
     * @param mixed $object
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function persistEntity($object): void
    {
        $this->manager->persist($object);
        $this->manager->flush();
    }

    public function getPaginatedDataSet(array $largeArray, int $page, int $pageSize): array
    {
        $offset = $this->getOffset($page, $pageSize);
        return (array_slice($largeArray, $offset, $pageSize));
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return float|int
     */
    protected function getOffset(int $page, int $pageSize)
    {
        return ($page - 1) * $pageSize;
    }
}
