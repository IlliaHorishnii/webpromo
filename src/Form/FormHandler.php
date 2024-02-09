<?php

namespace App\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class FormHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly FormFactoryInterface   $formFactory
    )
    {
    }

    /**
     * @param array $data
     * @param $entity
     * @param string $type
     * @return mixed
     */
    public function handler(array $data, $entity, string $type)
    {
        $form = $this->formFactory->create($type, $entity);

        $form->submit($data, false);
        if ($form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();
            return $entity;
        }

        throw new \Exception("invalid data", 403);
    }
}