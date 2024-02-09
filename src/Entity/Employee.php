<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Employee
{
    use DatetimeTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["list"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(["list"])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: ToDoItem::class, mappedBy: 'employee', orphanRemoval: true)]
    private Collection $toDoItems;

    public function __construct()
    {
        $this->toDoItems = new ArrayCollection();
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
     * @return Collection<int, ToDoItem>
     */
    public function getToDoItems(): Collection
    {
        return $this->toDoItems;
    }

    public function addToDoItem(ToDoItem $toDoItem): static
    {
        if (!$this->toDoItems->contains($toDoItem)) {
            $this->toDoItems->add($toDoItem);
            $toDoItem->setEmployee($this);
        }

        return $this;
    }

    public function removeToDoItem(ToDoItem $toDoItem): static
    {
        if ($this->toDoItems->removeElement($toDoItem)) {
            // set the owning side to null (unless already changed)
            if ($toDoItem->getEmployee() === $this) {
                $toDoItem->setEmployee(null);
            }
        }

        return $this;
    }
}
