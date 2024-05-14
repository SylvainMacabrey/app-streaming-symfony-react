<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
    * @return Movie[] Returns an array of Movie objects
    */
    public function search($title, $categories): array
    {
        $query = $this->createQueryBuilder('m')->join('m.categories', 'c')->addSelect('c');


        if (isset($title) && $title !== "") {
            $query->where('m.title LIKE :title')
                  ->setParameter('title', $title . "%");
        }

        if (isset($categories) && $categories !== "") {
            $categoriesList = explode(",", $categories);
            $query->andWhere('c.name IN (:categories)')
                  ->setParameter('categories', $categoriesList);
        }
        
        $query->orderBy('m.id', 'ASC')->setMaxResults(50);

        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Movie[] Returns an array of Movie objects
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

    //    public function findOneBySomeField($value): ?Movie
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
