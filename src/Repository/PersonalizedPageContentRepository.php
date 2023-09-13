<?php

namespace App\Repository;

use App\Entity\PersonalizedPageContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonalizedPageContent>
 *
 * @method PersonalizedPageContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalizedPageContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalizedPageContent[]    findAll()
 * @method PersonalizedPageContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalizedPageContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalizedPageContent::class);
    }

//    /**
//     * @return PersonalizedPageContent[] Returns an array of PersonalizedPageContent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PersonalizedPageContent
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
