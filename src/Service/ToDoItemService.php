<?php

namespace App\Service;

use App\Entity\ToDoItem;
use Doctrine\ORM\EntityManagerInterface;

class ToDoItemService
{

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @param ToDoItem[] $toDoList
     * @return ToDoItem[]
     */
    public function increaseViewCounter(array $toDoList): array
    {
        foreach ($toDoList as $item) {
            $item->setViewsCount($item->getViewsCount() + 1);

            if($item->getStatus() == ToDoItem::STATUS_NEW) {

                if($item->getCreatedAt() <= new \DateTime('-1 day')) {
                    $item->setStatus(ToDoItem::STATUS_IMPORTANT);
                } else {
                    $item->setStatus(ToDoItem::STATUS_VIEWED);
                }
            }
        }

        $this->entityManager->flush();

        return $toDoList;
    }
}
