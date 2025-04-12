<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Wordle;
use Symfony\Component\HttpFoundation\RequestStack;

class WordleController extends AbstractController
{
    #[Route("/wordle", name: "wordle")]
    public function index(EntityManagerInterface $entityManager, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();

        // vygeneruju nebo ziskam slovo ze session
        if(!$session->has('word')){
            $wordArr = $entityManager->getRepository(Wordle::class)->findAll();
            $max = count($wordArr);
            $randomIndex = rand(0, $max - 1); 
            $word = $wordArr[$randomIndex];

            $session->set('word', $word);
        }else{
            $word = $session->get('word');            
        }

        // ziskam co hadal a co to ma byt
        $guesses = $session->get('guesses', []);
        $actualWord = mb_strtolower($word->getWord());

        // vyresim co poslal a redirectnu zpatky
        if($_POST != null){
            $guess = mb_strtolower($_POST["guess"]);
            
            $colors = [];
            
            $wordArr = mb_str_split($actualWord);

            foreach (mb_str_split($guess) as $index => $letter) {
                if ($wordArr[$index] == $letter) {
                    $colors[] = 'green';
                } else if (str_contains($actualWord, $letter)){
                    $colors[] = 'orange';
                } else {
                    $colors[] = 'red';
                }
            }

            $guesses[] = [
                'guess' => $guess,
                'colors' => $colors
            ];

            $session->set('guesses', $guesses);
            
            return $this->redirectToRoute('wordle');
        }

        // kontrola posledniho slova, status
        $lastGuessedWord = empty($guesses) ? "" : mb_strtolower($guesses[count($guesses) - 1]['guess']);

        if($lastGuessedWord == $actualWord){    
            $status = 'win';     
        } else if (count($guesses) == 6){
            $status = 'lose';
        }
        
        return $this->render('wordle.html.twig', [
            "word" => $word,
            "guess" => $guess ?? "",
            "guesses" => $guesses,
            "status" => $status ?? null
        ]);
    }

    #[Route("/session", name: "session")]
    public function session(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $session->remove('guesses');
        $session->remove('word');
        return $this->redirectToRoute('wordle');
    }
}