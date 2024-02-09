<?php

namespace App\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class FormHandler
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
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