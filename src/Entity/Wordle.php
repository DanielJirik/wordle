<?php

namespace App\Entity;

use App\Repository\WordleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordleRepository::class)]
class Wordle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $word = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $last_used_at = null;

    /**
     * @var Collection<int, WordleAnswer>
     */
    #[ORM\OneToMany(targetEntity: WordleAnswer::class, mappedBy: 'wordle', orphanRemoval: true)]
    private Collection $wordleAnswers;

    public function __construct()
    {
        $this->wordleAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return mb_strtolower($this->word);
    }

    public function setWord(string $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getLastUsedAt(): ?\DateTimeImmutable
    {
        return $this->last_used_at;
    }

    public function setLastUsedAt(?\DateTimeImmutable $last_used_at): static
    {
        $this->last_used_at = $last_used_at;

        return $this;
    }

    /**
     * @return Collection<int, WordleAnswer>
     */
    public function getWordleAnswers(): Collection
    {
        return $this->wordleAnswers;
    }

    public function addWordleAnswer(WordleAnswer $wordleAnswer): static
    {
        if (!$this->wordleAnswers->contains($wordleAnswer)) {
            $this->wordleAnswers->add($wordleAnswer);
            $wordleAnswer->setWordle($this);
        }

        return $this;
    }

    public function removeWordleAnswer(WordleAnswer $wordleAnswer): static
    {
        if ($this->wordleAnswers->removeElement($wordleAnswer)) {
            // set the owning side to null (unless already changed)
            if ($wordleAnswer->getWordle() === $this) {
                $wordleAnswer->setWordle(null);
            }
        }

        return $this;
    }
}
