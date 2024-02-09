<?php

namespace App\Repository;

use App\Entity\ToDoItem;
use App\Helper\PaginationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ToDoItem>
 *
 * @method ToDoItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToDoItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToDoItem[]    findAll()
 * @method ToDoItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToDoItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToDoItem::class);
    }

    public function getListByEmployee(int $employeeId, ?array $pagination)
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.employee', 'e')
            ->andWhere('e.id = :employeeId')
            ->setParameter('employeeId', $employeeId)
        ;

        return PaginationHelper::applyPagination($qb, $pagination)->getQuery()->getResult();
    }
}
