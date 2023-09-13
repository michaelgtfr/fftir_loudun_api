<?php

namespace App\Repository;

use App\Entity\SportsShootingDisciplines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SportsShootingDisciplines>
 *
 * @method SportsShootingDisciplines|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsShootingDisciplines|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsShootingDisciplines[]    findAll()
 * @method SportsShootingDisciplines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsShootingDisciplinesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsShootingDisciplines::class);
    }

//    /**
//     * @return SportsShootingDisciplines[] Returns an array of SportsShootingDisciplines objects
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

//    public function findOneBySomeField($value): ?SportsShootingDisciplines
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
