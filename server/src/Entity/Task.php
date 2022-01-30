<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task implements \JsonSerializable
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;


    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: "tasks")]
    private $project;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "tasks")]
    private $assignee;

    #[ORM\Column(type: "string", length: 500, nullable: true)]
    private $description;

    #[ORM\OneToMany(targetEntity: TimeLog::class, mappedBy: "task", orphanRemoval: true)]
    private $timeLogs;

    public function __construct()
    {
        $this->timeLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * @return Collection|TimeLog[]
     */
    public function getTimeLogs(): Collection
    {
        return $this->timeLogs;
    }

    public function addTimeLog(TimeLog $timeLog): self
    {
        if (!$this->timeLogs->contains($timeLog)) {
            $this->timeLogs[] = $timeLog;
            $timeLog->setTask($this);
        }

        return $this;
    }

    public function removeTimeLog(TimeLog $timeLog): self
    {
        if ($this->timeLogs->removeElement($timeLog)) {
            // set the owning side to null (unless already changed)
            if ($timeLog->getTask() === $this) {
                $timeLog->setTask(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            "id"=>$this->id,
            "description"=>$this->description,
            "assignee"=>$this->getAssignee()->getUsername()
        ];
    }
}
