<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findByArticle(Article $article)
    {
        return $this->createQueryBuilder('c')
            ->where(':article MEMBER OF c.articles')
            ->setParameter('article', $article)->getQuery()->getResult();
    }

    public function findAllWithArticlesCount()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c')
            ->addSelect('COUNT(a) as total')
            ->leftJoin('c.articles', 'a')
            ->groupBy('c');
        $result = $queryBuilder->getQuery()->getResult();
        return array_map(function ($item) {
            $category = $item[0];
            $category->setTotalArticles($item['total']);
            return $category;
        }, $result);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
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
