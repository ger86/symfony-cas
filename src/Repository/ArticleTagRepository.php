<?php

namespace App\Repository;

use App\Entity\ArticleTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ArticleTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleTag[]    findAll()
 * @method ArticleTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleTag::class);
    }

    public function findBetweenDates(\DateTime $from, \DateTimeInterface $to) {
        return $this->createQueryBuilder('at')
            ->andWhere('at.createdAt BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ArticleTag[] Returns an array of ArticleTag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleTag
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
