<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\WordleService;

class WordleController extends AbstractController
{
    #[Route("/wordle", name: "wordle")]
    public function wordle(WordleService $wordleService): Response
    {
        $wordleAnswer = $wordleService->getTodaysWordleAnswer();
        $word = $wordleAnswer->getWordle()->getWord();
        $userWordleAnswer = $wordleService->getUserWordleAnswer($wordleAnswer, $this->getUser());

        if (isset($_GET['user']) && $userWordleAnswer->getStatus() == 'win') {
            $user = $this->entityManager->find(User::class, $_GET['user']);
            if ($user == null) {
                return $this->flashRedirect('error', 'Uzivatel nenalezen.', 'wordle');
            }
            $userWordleAnswer = $wordleService->getUserWordleAnswer($wordleAnswer, $user);
        }
        
        $guesses = $userWordleAnswer->getGuesses();

        if($_POST != null){
            $guess = mb_strtolower($_POST["guess"]);
            
            if (isset($user) && $user->getId() != $this->getUserInstance()->getId()) {
                return $this->flashRedirect('error', 'nehraj za ostatni cavo.', 'wordle');
            }
            if (mb_strlen($guess) != 5) {
                return $this->flashRedirect('error', '5 pismen debile.', 'wordle');
            }
            if ($userWordleAnswer->getStatus() != 'playing') {
                return $this->flashRedirect('error', 'Uz si dohral karecku.', 'wordle');
            }

            $guesses = $wordleService->getGuesses($guesses, $word, $guess);

            $userWordleAnswer->setGuesses($guesses);
            $userWordleAnswer->setAttempts($userWordleAnswer->getAttempts() + 1);

            $lastGuessedWord = empty($guesses) ? "" : $guesses[count($guesses) - 1]['guess'];
            $status = null;
            if($lastGuessedWord == $word){
                $status = 'win';     
            } else if (count($guesses) == 6){
                $status = 'lose';
            }

            if ($status) {
                $userWordleAnswer->setStatus($status);
            }

            $this->entityManager->flush();
            
            return $this->redirectToRoute('wordle');
        }
        
        return $this->render('wordle.html.twig', [
            "word" => $word,
            "guesses" => $guesses,
            "status" => $userWordleAnswer->getStatus()
        ]);
    }
}