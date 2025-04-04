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

        $guesses = $session->get('guesses', []);
        $guess = "";

        if(!$session->has('word')){
            $wordArr = $entityManager->getRepository(Wordle::class)->findAll();
            $max = count($wordArr);
            $randomIndex = rand(0, $max - 1); 
            $word = $wordArr[$randomIndex];

            $session->set('word', $word);
        }else{
            $word = $session->get('word');            
        }

        if($_POST != null){
            $guess = $_POST["guess"];
            
            $colors = [];
            
            $wordArr = mb_str_split($word->getWord());
            foreach (mb_str_split($guess) as $index => $letter) {
                //is valid
                //log
                if ($wordArr[$index] == $letter) {
                    $colors[] = 'green';
                } else if (str_contains($word->getWord(), $letter)){
                    $colors[] = 'orange';
                } else {
                    $colors[] = 'red';
                }
            }

            dd($colors);


            $guesses[] = [
                'guess' => $guess,
                'colors' => $colors
            ];


            $guesses[] = $guess; //"pridej na konec" $arr[] = $foo;
            $session->set('guesses', $guesses);

            if(count($guesses) == 6){                
                if(strtolower($guess) == strtolower($word->getWord())){    
                    $status = 'win';     
                } else {
                    $status = 'lose';
                }
            }

            if(strtolower($guess) == strtolower($word->getWord())){    
                $status = 'win';     
            }else{

            }
            
            // return $this->redirectToRoute('wordle');
        }       
        
        return $this->render('wordle.html.twig', [
            "word" => $word,
            "guess" => $guess,
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