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
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class LoginController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout(ClientRegistry $clientRegistry)
    {
        // Controller can be blank: Symfony will intercept this route.
        throw new \Exception('This should never be reached!');
    }

    #[Route('/login/discord', name: 'login_discord_start')]
    public function loginDiscord(ClientRegistry $clientRegistry)
    {
        // will redirect to Discord!
        return $clientRegistry
            ->getClient('discord') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
                'identify', 'email' // the scopes you want to access
            ], []);
    }

    #[Route('/login/discord/check', name: 'login_discord_check')]
    public function loginDiscordCheck(DiscordAuthenticator $discordAuth, Request $request, ClientRegistry $clientRegistry)
    {
        try {
            $passport = $discordAuth->authenticate($request);
        } catch (IdentityProviderException $e) {
            // something went wrong!
            $this->addFlash('danger', $e->getMessage());
        }
        return $this->redirectToRoute($request->getSession()->get('lastVisitedPage', 'home'));
    }
}
