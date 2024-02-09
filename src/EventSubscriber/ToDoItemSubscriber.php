<?php

namespace App\EventListener;

use App\Entity\BaseEntity;
use App\Entity\ToDoItem;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ToDoItemSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // return the subscribed events, their methods and priorities
        return [
            Events::postLoad
        ];
    }

    public function postLoad(PostLoadEventArgs $args)
    {
        $item = $args->getObject();
        if (!$this->supports($item)) return;
        $item->setViewsCount($item->getViewsCount() + 1);

        if($item->getStatus() == ToDoItem::STATUS_NEW) {

            if($item->getCreatedAt() <= new \DateTime('-1 day')) {
                $item->setStatus(ToDoItem::STATUS_IMPORTANT);
            } else {
                $item->setStatus(ToDoItem::STATUS_VIEWED);
            }
        }

        $args->getObjectManager()->flush();
    }

    private function supports(object $object): bool
    {
        return $object::class === ToDoItem::class;
    }
}