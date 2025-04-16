<?php

namespace App\Entity;

use App\Repository\UserWordleAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserWordleAnswerRepository::class)]
class UserWordleAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userWordleAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userWordleAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WordleAnswer $wordleAnswer = null;

    #[ORM\Column]
    private ?int $attempts = null;

    #[ORM\Column]
    private array $guesses = [];

    #[ORM\Column(length: 7)]
    private ?string $status = null;

    public function __construct(User $user, WordleAnswer $wordleAnswer)
    {
        $this->user = $user;
        $this->wordleAnswer = $wordleAnswer;
        $this->attempts = 0;
        $this->guesses = [];
        $this->status = 'playing';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getWordleAnswer(): ?WordleAnswer
    {
        return $this->wordleAnswer;
    }

    public function setWordleAnswer(?WordleAnswer $wordleAnswer): static
    {
        $this->wordleAnswer = $wordleAnswer;

        return $this;
    }

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function setAttempts(int $attempts): static
    {
        $this->attempts = $attempts;

        return $this;
    }

    public function getGuesses(): array
    {
        return $this->guesses;
    }

    public function setGuesses(array $guesses): static
    {
        $this->guesses = $guesses;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
