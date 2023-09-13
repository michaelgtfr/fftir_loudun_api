<?php

namespace App\Repository;

use App\Entity\Schredule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schredule>
 *
 * @method Schredule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schredule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schredule[]    findAll()
 * @method Schredule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchreduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schredule::class);
    }

//    /**
//     * @return Schredule[] Returns an array of Schredule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Schredule
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
