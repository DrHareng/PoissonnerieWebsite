<?php

namespace App\Controller;

use App\Security\DiscordAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(Request $request): Response
    {
        $request->getSession()->set('lastVisitedPage', 'home');
        return $this->render('main/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
