<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserWordleAnswer;
use App\Entity\Wordle;
use App\Entity\WordleAnswer;
use Doctrine\ORM\EntityManagerInterface;

class WordleService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getTodaysWordleAnswer() : WordleAnswer
    {
        $wordleAnswer = $this->entityManager->getRepository(WordleAnswer::class)->findOneBy(['date' => new \DateTimeImmutable('now')]);
        if ($wordleAnswer === null) {
            $wordleAnswer = new WordleAnswer();
            $wordleAnswer->setDate(new \DateTimeImmutable('now'));
            $wordles = $this->entityManager->getRepository(Wordle::class)
                ->createQueryBuilder('w')
                ->where('w.last_used_at IS NULL OR w.last_used_at < :date')
                ->setParameter('date', (new \DateTimeImmutable('now'))->modify('-14 days'))
                ->getQuery()
                ->getResult();
            
            $wordle = $wordles[array_rand($wordles)];
            $wordleAnswer->setWordle($wordle);

            $wordle->setLastUsedAt(new \DateTimeImmutable('now'));

            $this->entityManager->persist($wordleAnswer);
            $this->entityManager->flush();
        }

        return $wordleAnswer;
    }

    public function getUserWordleAnswer(WordleAnswer $wordleAnswer, User $user) : UserWordleAnswer
    {
        $userWordleAnswer = $this->entityManager->getRepository(UserWordleAnswer::class)
            ->findOneBy(['wordleAnswer' => $wordleAnswer, 'user' => $user]);

        if ($userWordleAnswer === null) {
            $userWordleAnswer = new UserWordleAnswer($user, $wordleAnswer);
            $this->entityManager->persist($userWordleAnswer);
            $this->entityManager->flush();
        }

        return $userWordleAnswer;
    }

    public function getGuesses(array $previousGuesses, string $word, string $guess) : array
    {
        $guesses = $previousGuesses;
        $colors = [];
        $wordArr = mb_str_split($word);
        foreach (mb_str_split($guess) as $index => $letter) {
            if ($wordArr[$index] == $letter) {
                $colors[] = 'green';
            } else if (str_contains($word, $letter)){
                $colors[] = 'orange';
            } else {
                $colors[] = 'red';
            }
        }
        $guesses[] = [
            'guess' => $guess,
            'colors' => $colors
        ];

        return $guesses;
    }
}