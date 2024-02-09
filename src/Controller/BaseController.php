<?php

namespace App\Controller;

use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseController extends AbstractController
{
    protected Request $request;

    public function __construct(
        RequestStack $requestStack,
        protected readonly EntityManagerInterface $entityManager,
        private readonly SerializerService $serializer
    )
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    protected function response($data, $groups)
    {
        $data = $this->serializer->toArray($data, $groups);

        return new JsonResponse($data, 200);
    }
}
