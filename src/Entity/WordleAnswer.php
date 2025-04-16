<?php

namespace App\Entity;

use App\Repository\WordleAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordleAnswerRepository::class)]
class WordleAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wordleAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wordle $wordle = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    /**
     * @var Collection<int, UserWordleAnswer>
     */
    #[ORM\OneToMany(targetEntity: UserWordleAnswer::class, mappedBy: 'wordleAnswer', orphanRemoval: true)]
    private Collection $userWordleAnswers;

    public function __construct()
    {
        $this->userWordleAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWordle(): ?Wordle
    {
        return $this->wordle;
    }

    public function setWordle(?Wordle $wordle): static
    {
        $this->wordle = $wordle;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, UserWordleAnswer>
     */
    public function getUserWordleAnswers(): Collection
    {
        return $this->userWordleAnswers;
    }

    public function addUserWordleAnswer(UserWordleAnswer $userWordleAnswer): static
    {
        if (!$this->userWordleAnswers->contains($userWordleAnswer)) {
            $this->userWordleAnswers->add($userWordleAnswer);
            $userWordleAnswer->setWordleAnswer($this);
        }

        return $this;
    }

    public function removeUserWordleAnswer(UserWordleAnswer $userWordleAnswer): static
    {
        if ($this->userWordleAnswers->removeElement($userWordleAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userWordleAnswer->getWordleAnswer() === $this) {
                $userWordleAnswer->setWordleAnswer(null);
            }
        }

        return $this;
    }
}
