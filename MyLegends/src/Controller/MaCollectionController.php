<?php

namespace App\Controller;

use App\Entity\MaCollection;
use App\Entity\Member;
use App\Form\MaCollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MaCollectionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


class MaCollectionController extends AbstractController
{
    

    
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index()
    {
        return $this->render('index.html.twig', [
            'welcome' => "Bienvenue sur le site de collection des cartes des légendes africaines",
        ]);
    }
  
    
    /**
     * Lists all MaCollection entities.
     */
    #[Route('/ma/collection/', name: 'collection_list', methods: ['GET'])]
    public function indexAction(MaCollectionRepository $maCollectionRepository): Response
    {
        $macollections = $maCollectionRepository->findAll();
        
        return $this->render('ma_collection/index.html.twig', [
            'macollections' => $macollections,
        ]);
    }
    
    #[Route('/ma/collection/new/{id}', name: 'app_macollection_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MaCollectionRepository $macollectionRepository,Member $membre): Response
    {
        $macollection = new MaCollection();
        $macollection->setMember($membre);
        $form = $this->createForm(MaCollectionType::class, $macollection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($macollection);
            $entityManager->flush();
            
            return $this->redirectToRoute('collection_list', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('ma_collection/new.html.twig', [
            'macollection' => $macollection,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_macollection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MaCollection $macollection, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaCollectionType::class, $macollection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('collection_list', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('ma_collection/edit.html.twig', [
            'macollection' => $macollection,
            'form' => $form,
        ]);
    }
    
    /**
     * Delete a Collection
     *
     * @param Integer $id (note that the id must be an integer)
     */
    
    #[Route('/{id}', name: 'app_macollection_delete', methods: ['POST'])]
    public function delete(Request $request, MaCollection $macollection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$macollection->getId(), $request->request->get('_token'))) {
            $entityManager->remove($macollection);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('collection_list', [], Response::HTTP_SEE_OTHER);
    }

    
    /**
     * Show a Collection
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/ma/collection/{id}', name: 'collection_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $MaCollectionRepo = $doctrine->getRepository(MaCollection::class);
        $MaCollection = $MaCollectionRepo->find($id);
        
        if (!$MaCollection) {
            throw $this->createNotFoundException('The collection does not exist');
        }
        
        return $this->render('ma_collection/show.html.twig', [
            'MaCollection' => $MaCollection,
        ]);
    }
}
