<?php

namespace App\Repository;

use App\Entity\Stash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stash|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stash|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stash[]    findAll()
 * @method Stash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stash::class);
    }

    // /**
    //  * @return Stash[] Returns an array of Stash objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stash
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
