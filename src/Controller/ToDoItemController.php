<?php

namespace App\Controller;

use App\Entity\ToDoItem;
use App\Form\FormHandler;
use App\Form\ToDoItemType;
use App\Repository\ToDoItemRepository;
use App\Service\ToDoItemService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/to-do-item')]
class ToDoItemController extends BaseController
{
    #[Route('/list/{employeeId}', name: 'get_to_do_list', methods: ['GET'])]
    public function list(ToDoItemService $toDoItemService): JsonResponse
    {
        $employeeId = $this->request->get('employeeId');

        /** @var  ToDoItemRepository $repo */
        $repo = $this->entityManager->getRepository(ToDoItem::class);
        $toDoList = $repo->getListByEmployee($employeeId,  $this->request->query->all());

        $toDoList = $toDoItemService->increaseViewCounter($toDoList);
        return $this->response($toDoList, ['groups' => ['list', 'employee']]);
    }

    /**
     * @throws \Exception
     */
    #[Route('', name: 'add_item', methods: ['POST'])]
    public function addItem(FormHandler $formHandler): JsonResponse
    {
        $formHandler->handler($this->request->toArray(), new ToDoItem(), ToDoItemType::class);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/update-text/{itemId}', name: 'update_item_text', methods: ['PUT'])]
    public function updateItemText(): JsonResponse
    {
        $itemId = $this->request->get('itemId');
        if(!$toDoItem = $this->entityManager->getRepository(ToDoItem::class)->findOneBy(['id' => $itemId])) {
            return new JsonResponse([
                'message' => 'Item not found'
            ], 404);
        }

        $data = $this->request->toArray();

        $text = $data['text'] ?? '';
        $toDoItem->setText($text);

        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }

    /**
     * @throws \Exception
     */
    #[Route('/mark-as-done/{itemId}', name: 'mark_item_as_done', methods: ['PUT'])]
    public function markAsDone(): JsonResponse
    {
        $itemId = $this->request->get('itemId');
        if(!$toDoItem = $this->entityManager->getRepository(ToDoItem::class)->findOneBy(['id' => $itemId])) {
            return new JsonResponse([
                'message' => 'Item not found'
            ], 404);
        }

        $toDoItem->setStatus(ToDoItem::STATUS_DONE);
        $toDoItem->setIsDone(true);
        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }

    #[Route('/{itemId}', name: 'remove_item', methods: ['DELETE'])]
    public function removeItem(): JsonResponse
    {
        $itemId = $this->request->get('itemId');
        if(!$toDoItem = $this->entityManager->getRepository(ToDoItem::class)->findOneBy(['id' => $itemId])) {
            return new JsonResponse([
                'message' => 'Item not found'
            ], 404);
        }

        $this->entityManager->remove($toDoItem);
        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }
}
