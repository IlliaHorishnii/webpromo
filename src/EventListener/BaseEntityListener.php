<?php

namespace App\EventListener;

use App\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

class BaseEntityListener
{
    #[ORM\PrePersist]
    public function prePersist(BaseEntity $entity)
    {
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setCreatedAt(new \DateTime('now'));
    }

    #[ORM\PreUpdate]
    public function preUpdate(BaseEntity $entity)
    {
        $entity->setUpdatedAt(new \DateTime('now'));
    }
}