<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SettingsType;
use App\Services\WordleService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "main")]
    public function index(WordleService $wordleService): Response
    {
        $todaysWordleAnswer = $wordleService->getTodaysWordleAnswer();

        if ($this->getUser()) {
            $userWordleAnswer = $wordleService->getUserWordleAnswer($todaysWordleAnswer, $this->getUser());
        }

        $leaderboard = [];
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $userAnswers = $user->getUserWordleAnswers();

            $totalGames = count($userAnswers);
            $totalWins = 0;
            $totalTriesOnWins = 0;
            $playedToday = null;

            foreach ($userAnswers as $answer) {
                if ($answer->getWordleAnswer()->getId() === $todaysWordleAnswer->getId()) {
                    $playedToday = $answer->getStatus() === 'playing' ? '—' : $answer->getStatus();
                }

                if ($answer->getStatus() === 'win') {
                    $totalWins++;
                    $totalTriesOnWins += $answer->getAttempts();
                }
            }

            $accuracy = $totalGames > 0 ? round(($totalWins / $totalGames) * 100, 1) : 0;
            $avgTry = $totalWins > 0 ? round($totalTriesOnWins / $totalWins, 2) : '—';

            $leaderboard[] = [
                'username' => $user->getUsername(),
                'avatar' => $user->getAvatar(),
                'playedToday' => $playedToday ?? '—',
                'totalGuessed' => $totalWins,
                'accuracy' => $accuracy,
                'avgTry' => $avgTry,
                'id' => $user->getId()
            ];
        }

        // Optional: sort leaderboard by most guessed, or lowest avgTry, etc.
        usort($leaderboard, fn($a, $b) => $b['totalGuessed'] <=> $a['totalGuessed']);

        return $this->render('main.html.twig', [
            'wordleAnswer' => $todaysWordleAnswer,
            'userWordleAnswer' => $userWordleAnswer ?? null,
            'leaderboard' => $leaderboard,
        ]);
    }

    #[Route("/settings", name: "settings")]
    public function settings(Request $request): Response
    {
        $form = $this->createForm(SettingsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData();
            $image = $form->get('image')->getData();

            $newFileName = uniqid() . "." . $image->guessExtension();

            try {
                $image->move(
                    $this->getParameter('kernel.project_dir') . "/public/uploads",
                    $newFileName
                );
            } catch (FileException $e) {
                return new Response($e->getMessage());
            }

            $this->getUserInstance()->setAvatar($newFileName);
            $this->entityManager->flush();

            return $this->flashRedirect('notice', 'Profilová fotka byla úspěšně změněna.', 'main');
        }

        return $this->render('settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}