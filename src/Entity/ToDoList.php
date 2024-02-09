<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToDoListRepository::class)]
class ToDoList extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: ToDoListItem::class, mappedBy: 'toDoList', orphanRemoval: true)]
    private Collection $toDoListItems;

    public function __construct()
    {
        $this->toDoListItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ToDoListItem>
     */
    public function getToDoListItems(): Collection
    {
        return $this->toDoListItems;
    }

    public function addToDoListItem(ToDoListItem $toDoListItem): static
    {
        if (!$this->toDoListItems->contains($toDoListItem)) {
            $this->toDoListItems->add($toDoListItem);
            $toDoListItem->setToDoList($this);
        }

        return $this;
    }

    public function removeToDoListItem(ToDoListItem $toDoListItem): static
    {
        if ($this->toDoListItems->removeElement($toDoListItem)) {
            // set the owning side to null (unless already changed)
            if ($toDoListItem->getToDoList() === $this) {
                $toDoListItem->setToDoList(null);
            }
        }

        return $this;
    }
}
