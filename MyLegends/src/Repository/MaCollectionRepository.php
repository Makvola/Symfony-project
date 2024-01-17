<?php

namespace App\Repository;

use App\Entity\MaCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MaCollection>
 *
 * @method MaCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaCollection[]    findAll()
 * @method MaCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaCollection::class);
    }

//    /**
//     * @return MaCollection[] Returns an array of MaCollection objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MaCollection
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
