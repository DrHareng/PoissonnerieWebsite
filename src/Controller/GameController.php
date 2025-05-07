<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameResult;
use App\Entity\PlayerGame;
use App\Entity\PlayerGameResult;
use App\Form\GameResultType;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\GameResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/games', name: 'game_list')]
    public function index(GameRepository $repository): Response
    {
        $games = $repository->findAllWithResultOrderedByDate();

        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/games/new-game-withresult', name: 'game__with_result_new')]
    public function newResult(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();

        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game->getGameResult()->setDate(new \DateTime());
            $game->getGameResult()->setRegisteredBy($this->getUser());
            $game->getGameResult()->setStatus(GameResult::STATUS_WAITING_VALIDATION);

            // Calculate tournament points for both players:
            $player1OP = $game->getGameResult()->getPlayer1Result()->getObjectivePoints();
            $player2OP = $game->getGameResult()->getPlayer2Result()->getObjectivePoints();
            if($player1OP == $player2OP){
                $player1TP = $player2TP = 2;
            }
            else if($player1OP > $player2OP){
                $player1TP = 4;
                $player2TP = (($player1OP - $player2OP) <= 2) ? 1 : 0;
            }
            else{
                $player2TP = 4;
                $player1TP = (($player2OP - $player1OP) <= 2) ? 1 : 0;
            }
            if($player1OP >= 5) $player1TP++;
            if($player2OP >= 5) $player2TP++;

            $game->getGameResult()->getPlayer1Result()->setTournamentPoints($player1TP);
            $game->getGameResult()->getPlayer2Result()->setTournamentPoints($player2TP);

            $game->getGameResult()->getPlayer1Result()->setPlayerGame($game->getPlayer1());
            $game->getGameResult()->getPlayer2Result()->setPlayerGame($game->getPlayer2());
            
            $game->addPlayerGame($game->getPlayer1());
            $game->addPlayerGame($game->getPlayer2());
            $game->getGameResult()->addPlayerGameResult($game->getGameResult()->getPlayer1Result());
            $game->getGameResult()->addPlayerGameResult($game->getGameResult()->getPlayer2Result());

            $entityManager->persist($game);
            $entityManager->flush();
    
            return $this->redirectToRoute('game_list');
        }
    
        return $this->render('game/new_game_with_result.html.twig', [
            'form' => $form,
        ]);
    }
    

}
