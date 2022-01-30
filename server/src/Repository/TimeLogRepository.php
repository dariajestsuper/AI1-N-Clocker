<?php

namespace App\Repository;

use App\Configuration\EntityManager;
use App\Entity\Project;
use App\Entity\TimeLog;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;

class TimeLogRepository extends EntityRepository
{
    public static function create(?\Doctrine\ORM\EntityManager $em = null): self
    {
        return new TimeLogRepository($em ?? EntityManager::getEntityManager(), new ClassMetadata(TimeLog::class));
    }

    public function getEntityManager()
    {
        return parent::getEntityManager();
    }

    public function findByProjectIdAndTaskIdAndId(int $projectId, int $taskId, int $id)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.task','p',Expr\Join::WITH, 'p.id = t.task')
            ->andWhere('p.id = :val')
            ->andWhere('t.id = :val2')
            ->andWhere('t.task = :val3')
            ->setParameter('val', $projectId)
            ->setParameter('val2', $id)
            ->setParameter('val3',$taskId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    // /**
    //  * @return TimeLog[] Returns an array of TimeLog objects
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
    public function findOneBySomeField($value): ?TimeLog
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
