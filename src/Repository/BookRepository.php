<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    
    /**
     * @param float $minPrice
     * @return Book[]
     */
    public function findBooksByMinPrice(float $minPrice): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.price > :minPrice')
            ->setParameter('minPrice', $minPrice)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Book[]
     */
    public function findRecentBooks(): array
    {
        $thirtyDaysAgo = new \DateTime();
        $thirtyDaysAgo->modify('-30 days');

        return $this->createQueryBuilder('b')
            ->andWhere('b.publishedAt > :thirtyDaysAgo')
            ->setParameter('thirtyDaysAgo', $thirtyDaysAgo)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $title
     * @return Book[]
     */
    public function findBooksByTitle(string $title): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('LOWER(b.title) LIKE LOWER(:title)')
            ->setParameter('title', '%' . $title . '%')
            ->getQuery()
            ->getResult();
    }
}
