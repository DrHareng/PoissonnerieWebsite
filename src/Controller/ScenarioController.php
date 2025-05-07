<?php

namespace App\Controller;

use App\Entity\Scenario;
use App\Entity\ScenarioPack;
use App\Form\ScenarioPackType;
use App\Form\ScenarioType;
use App\Repository\ScenarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ScenarioController extends AbstractController
{
    #[Route('/scenario/new-pack', name: 'scenario_new_pack')]
    public function addnewPack(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $scenarioPack = new ScenarioPack();
        $form = $this->createForm(ScenarioPackType::class, $scenarioPack);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($scenarioPack);
            $em->flush();
            $this->addFlash('success', 'Pack de scénario ajouté.');

            return $this->redirectToRoute('scenario_list');
        }

        return $this->render('scenario/new_scenario_pack.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/scenario/{id}/edit', name: 'scenario_edit')]
    public function editScenario(Scenario $scenario, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ScenarioType::class, $scenario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Scénario été mis à jour.');

            return $this->redirectToRoute('scenario_list');
        }

        return $this->render('scenario/scenario_edit.html.twig', [
            'form' => $form,
            'scenario' => $scenario,
        ]);
    }
    #[Route('/scenario/new-scenario', name: 'scenario_new_scenario')]
    public function addNewScenario(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $scenario = new Scenario();
        $form = $this->createForm(ScenarioType::class, $scenario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($scenario);
            $em->flush();
            $this->addFlash('success', 'Scénario ajouté.');

            return $this->redirectToRoute('scenario_list');
        }

        return $this->render('scenario/new_scenario.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/scenario', name: 'scenario_list')]
    public function index(ScenarioRepository $scenarioRepository): Response
    {
        $scenarios = $scenarioRepository->findAllOrderedByPackAndName();
        $packCounts = [];
        foreach($scenarios as $scenario){
            $packname = $scenario->getPack() != null ? $scenario->getPack()->getName() : '-';
            if(!array_key_exists($packname, $packCounts)){
                $packCounts[$packname] = 0;
            }
            $packCounts[$packname] += 1;
        }
        return $this->render('scenario/index.html.twig', [
            'scenarios' => $scenarios,
            'pack_counts' => $packCounts,
        ]);
    }
}
