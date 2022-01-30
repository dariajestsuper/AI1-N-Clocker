<?php

namespace App\Repository;

use App\Configuration\EntityManager;
use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;


class TaskRepository extends EntityRepository
{
    public static function create(?\Doctrine\ORM\EntityManager $em = null): self
    {
        return new TaskRepository($em ?? EntityManager::getEntityManager(), new ClassMetadata(Task::class));
    }

    public function getEntityManager()
    {
        return parent::getEntityManager();
    }

    public function findOneByProjectIdAndId(int $projectId, int $id): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.project = :val')
            ->andWhere('t.id = :val2')
            ->setParameter('val', $projectId)
            ->setParameter('val2', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
