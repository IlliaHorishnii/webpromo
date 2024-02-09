<?php

namespace App\Entity;

use App\Repository\ToDoItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ToDoItemRepository::class)]
class ToDoItem extends BaseEntity
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
    #[Groups(["list"])]
    private ?bool $isDone = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["list"])]
    private ?string $text = null;

    #[ORM\Column]
    #[Groups(["list"])]
    private ?int $viewsCount = 0;

    #[ORM\Column(length: 255)]
    #[Groups(["list"])]
    private ?string $status = self::STATUS_NEW;

    #[ORM\ManyToOne(inversedBy: 'toDoItems')]
    #[Assert\NotBlank]
    #[Groups(["employee"])]
    private ?Employee $employee = null;

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
            throw new \Exception("invalid status", 403);
        }

        $this->status = $status;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }
}
