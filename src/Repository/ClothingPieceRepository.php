<?php

namespace App\Repository;

use App\Entity\ClothingPiece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClothingPiece|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClothingPiece|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClothingPiece[]    findAll()
 * @method ClothingPiece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClothingPieceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClothingPiece::class);
    }

    // /**
    //  * @return ClothingPiece[] Returns an array of ClothingPiece objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClothingPiece
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
