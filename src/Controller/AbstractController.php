<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as AbstractControllerBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AbstractController extends AbstractControllerBase
{
    protected AuthorizationCheckerInterface $authChecker;
    protected EntityManagerInterface $entityManager;

    public function injectionServices(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
        $this->entityManager = $entityManager;
    }

    protected function getGlobalParameters(): array
    {
        return [];
    }

    protected function renderView(string $view, array $parameters = []): string
    {
        return get_parent_class()::renderView($view, array_merge($parameters, $this->getGlobalParameters()));
    }

    protected function render(string $view, array $parameters = [], ?Response $response = null) : Response
    {
        return get_parent_class()::render($view, array_merge($parameters, $this->getGlobalParameters()));
    }

    protected function flashRedirect(
        string $type,
        string $message,
        string $route,
        ?array $parameters = []
    ): RedirectResponse {
        $this->addFlash($type, $message);
        return $this->redirectToRoute($route, $parameters);
    }

    protected function getUserInstance() : User
    {
        $user = $this->getUser();
        assert($user instanceof User);
        return $user;
    }
}