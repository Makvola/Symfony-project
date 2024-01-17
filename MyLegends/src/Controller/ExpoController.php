<?php

namespace App\Controller;

use App\Entity\Expo;
use App\Entity\Member;
use App\Entity\CarteJoueur;
use App\Form\ExpoType;
use App\Repository\ExpoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/expo')]
class ExpoController extends AbstractController
{
    #[Route('/', name: 'app_expo_index', methods: ['GET'])]
    public function index(ExpoRepository $expoRepository): Response
    {
        return $this->render('expo/index.html.twig', [
            'expos' => $expoRepository->findBy(['publiee' => true]),
        ]);
    }

    #[Route('/new/{id}', name: 'app_expo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ExpoRepository $expoRepository, Member $membre): Response
    {
        $expo = new Expo();
        $expo->setCreateur($membre);
        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($expo);
            $entityManager->flush();

            return $this->redirectToRoute('app_expo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expo/new.html.twig', [
            'expo' => $expo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expo_show', methods: ['GET'])]
    public function show(Expo $expo): Response
    {
        return $this->render('expo/show.html.twig', [
            'expo' => $expo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_expo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Expo $expo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_expo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expo/edit.html.twig', [
            'expo' => $expo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expo_delete', methods: ['POST'])]
    public function delete(Request $request, Expo $expo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($expo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_expo_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{expo_id}/carte/{carte_id}', methods: ['GET'], name: 'app_expo_carte_show')]
    public function carteShow(
        #[MapEntity(id: 'expo_id')]
        Expo $expo,
        #[MapEntity(id: 'carte_id')]
        CarteJoueur $carte
        ): Response
        {
            if(! $expo->getCartes()->contains($carte)) {
                throw $this->createNotFoundException("Couldn't find such a [objet] in this exposition!");
            }
            
            if(! $expo->isPubliee()) {
                throw $this->createAccessDeniedException("You cannot access the requested ressource!");
            }
            return $this->render('expo/carte_show.html.twig', [
                'carte' => $carte,
                'expo' => $expo
            ]);
    }

    
}
