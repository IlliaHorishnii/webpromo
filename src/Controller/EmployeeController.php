<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Form\FormHandler;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employee')]
class EmployeeController extends BaseController
{
    #[Route('', name: 'get_employee_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $pagination = $this->request->query->get('pagination');

        /** @var  EmployeeRepository $repo */
        $repo = $this->entityManager->getRepository(Employee::class);
        $employees = $repo->getList($pagination);

        return $this->response($employees, ['groups' => ['list']]);
    }

    #[Route('', name: 'add_employee', methods: ['POST'])]
    public function addEmployee(FormHandler $formHandler): JsonResponse
    {
        try {
             $formHandler->handler($this->request->toArray(), new Employee(), EmployeeType::class);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return $this->json(['message' => 'ok']);
    }

    #[Route('/{employeeId}', name: 'remove_employee', methods: ['DELETE'])]
    public function removeEmployee(): JsonResponse
    {
        $employeeId = $this->request->get('employeeId');
        if(!$employee = $this->entityManager->getRepository(Employee::class)->findOneBy(['id' => $employeeId])) {
            return new JsonResponse([
                'message' => 'Employee not found'
            ], 404);
        }

        $this->entityManager->remove($employee);
        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }
}
