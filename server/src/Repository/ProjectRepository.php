<?php

namespace App\Repository;

use App\Configuration\EntityManager;
use App\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class ProjectRepository extends EntityRepository
{
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }

    public static function create(?\Doctrine\ORM\EntityManager $em = null): self
    {
        return new ProjectRepository($em ?? EntityManager::getEntityManager(), new ClassMetadata(Project::class));
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
