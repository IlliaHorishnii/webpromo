<?php

namespace App\Entity;

use App\Repository\ToDoListItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

#[ORM\Entity(repositoryClass: ToDoListItemRepository::class)]
class ToDoListItem extends BaseEntity
{
    const STATUS_NEW = "NEW";
    const STATUS_VIEWED = "VIEWED";
    const STATUS_IMPORTANT = "IMPORTANT";
    const STATUS_DONE = "DONE";

    const STATUSES = [self::STATUS_NEW, self::STATUS_VIEWED, self::STATUS_IMPORTANT, self::STATUS_DONE];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isDone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $viewsCount = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'toDoListItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ToDoList $toDoList = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): static
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getViewsCount(): ?int
    {
        return $this->viewsCount;
    }

    public function setViewsCount(int $viewsCount): static
    {
        $this->viewsCount = $viewsCount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        if(!in_array($status, self::STATUSES)) {
            throw new Exception("invalid status", 403);
        }

        $this->status = $status;

        return $this;
    }

    public function getToDoList(): ?ToDoList
    {
        return $this->toDoList;
    }

    public function setToDoList(?ToDoList $toDoList): static
    {
        $this->toDoList = $toDoList;

        return $this;
    }
}
