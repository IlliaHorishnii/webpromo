<?php

namespace App\Repository;

use App\Entity\ToDoListItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ToDoListItem>
 *
 * @method ToDoListItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToDoListItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToDoListItem[]    findAll()
 * @method ToDoListItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToDoListItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToDoListItem::class);
    }

//    /**
//     * @return ToDoListItem[] Returns an array of ToDoListItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ToDoListItem
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
