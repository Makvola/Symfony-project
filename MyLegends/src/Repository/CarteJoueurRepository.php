<?php

namespace App\Repository;

use App\Entity\CarteJoueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarteJoueur>
 *
 * @method CarteJoueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarteJoueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarteJoueur[]    findAll()
 * @method CarteJoueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteJoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteJoueur::class);
    }

//    /**
//     * @return CarteJoueur[] Returns an array of CarteJoueur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CarteJoueur
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
