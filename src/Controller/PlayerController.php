<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractController
{
    #[Route('/players', name: 'player_list')]
    public function playerList(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('players/player_list.html.twig', [
            'users' => $users,
        ]);
    }
}
