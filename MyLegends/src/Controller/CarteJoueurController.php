<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MaCollection;
use App\Entity\CarteJoueur;
use App\Form\CarteJoueurType;
use App\Repository\CarteJoueurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class CarteJoueurController extends AbstractController
{
    /**
    * Show a player card
    *
    * @param Integer $id (note that the id must be an integer)
    */
    #[Route('/carte/joueur/{id}', name: 'carte_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $CarteRepo = $doctrine->getRepository(CarteJoueur::class);
        $Carte = $CarteRepo->find($id);
        
        if (!$Carte) {
            throw $this->createNotFoundException('The card does not exist');
        }
        
        return $this->render('carte_joueur/show.html.twig', [
            'Carte' => $Carte,
        ]);
    }
    
    #[Route('/carte/joueur/new/{id}', name: 'app_carte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CarteJoueurRepository $carteRepository, MaCollection $maCollection): Response
    {
        $carte = new CarteJoueur();
        $carte->setMaCollection($maCollection);
        $form = $this->createForm(CarteJoueurType::class, $carte);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carte);
            $entityManager->flush();
            
            #return $this->redirectToRoute('collection_show', $carte.maCollection.id, [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('collection_show', ['id' => $maCollection->getId()], Response::HTTP_SEE_OTHER);
            
        }
        
        return $this->render('carte_joueur/new.html.twig', [
            'carte' => $carte,
            'form' => $form,
        ]);
    }
    
    #[Route('/carte/joueur/{id}/edit', name: 'app_carte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarteJoueur $carte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarteJoueurType::class, $carte);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            #return $this->redirectToRoute('collection_show', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('carte_show', ['id' => $carte->getId()], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('carte_joueur/edit.html.twig', [
            'carte' => $carte,
            'form' => $form,
        ]);
    }
    
    #[Route('/carte/joueur/{id}', name: 'app_carte_delete', methods: ['POST'])]
    public function delete(Request $request, CarteJoueur $carte, EntityManagerInterface $entityManager): Response
    {
        $i=$carte->getMaCollection();
        $u=$i->getId();
        #$y=$u->getId();
        
        if ($this->isCsrfTokenValid('delete'.$carte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($carte);
            $entityManager->flush();
        }
        
        #return $this->redirectToRoute('collection_list', [], Response::HTTP_SEE_OTHER);
        #eturn $this->redirectToRoute('collection_show', ['id' => $i], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('collection_show', ['id'=>$u], Response::HTTP_SEE_OTHER);
    }
    
    
}
